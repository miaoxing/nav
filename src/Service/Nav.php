<?php

namespace Miaoxing\Nav\Service;

/**
 * @property \Miaoxing\LinkTo\Service\LinkTo $linkTo
 * @property \Wei\View $view $view
 * @property \Wei\Request $request
 */
class Nav extends \Miaoxing\Plugin\BaseService
{
    protected $data = [
        'position' => 'bottom',
        'color' => '#333',
        'bgColor' => '#ff',
        'display' => 'all',
    ];

    protected $table = 'navs';

    /**
     * @var NavLink|NavLink[]
     */
    protected $links;

    protected $providers = [
        'db' => 'app.db',
    ];

    protected $types = ['header', 'footer'];

    public function getLinks()
    {
        $this->links || $this->links = wei()->navLink()->desc('sort')->findAll([
            'navId' => $this['id'],
            'parentId' => '0',
        ]);

        return $this->links;
    }

    public function setLinks(NavLink $links)
    {
        $this->links = $links;

        return $this;
    }

    public function reloadLinks()
    {
        $this->links = null;

        return $this->getLinks();
    }

    /**
     * 获取缓存的数据
     *
     * @return array
     */
    public function getCacheData()
    {
        $data = [];
        $navs = wei()->nav()->curApp()->enabled()->findAll(['type' => $this->types]);

        foreach ($navs as $i => $nav) {
            $links = [];
            /** @var NavLink $link */
            foreach ($nav->getLinks() as $link) {
                $links[] = $link->toArray([
                        'type',
                        'name',
                        'icon',
                        'image',
                        'activeImage',
                        'font',
                        'customFont',
                        'bgColor',
                        'side',
                        'display',
                        'linkTo',
                    ]) + [
                        'subLinks' => $link->getSubLinks()->toArray(['name', 'linkTo']),
                    ];
            }

            $data[] = $nav->toArray(['id', 'type', 'color', 'activeColor', 'bgColor']) + [
                    'links' => $links,
                ];
        }

        return $data;
    }

    /**
     * 重建缓存数据
     */
    public function refreshCache()
    {
        wei()->cache->set($this->getRenderCacheKey(), $this->getCacheData(), 86400);
    }

    /**
     * 渲染导航
     *
     * @param array $pageConfig
     * @param string $title
     */
    public function display($pageConfig, $title = null)
    {
        $navs = (array) wei()->cache->remember($this->getRenderCacheKey(), 86400, function () {
            return $this->getCacheData();
        });

        foreach ($navs as $nav) {
            if (!$pageConfig['display' . ucfirst($nav['type'])]) {
                continue;
            }
            $this->event->trigger('navRender' . ucfirst($nav['type']), [$nav, $title]);
        }
    }

    /**
     * 渲染一组链接
     *
     * 对于这种PHP很重的模板,在PHP中处理比在视图中处理更合适
     *
     * @param array $links
     * @return string
     */
    protected function renderLinks($links)
    {
        $html = '';
        $navLink = wei()->navLink;

        /** @var NavLink $link */
        foreach ($links as $link) {
            $url = $link['subLinks'] ? 'javascript:;' : $this->linkTo->getUrl($link['linkTo']);
            $html .= '<a href="' . $url . '" class="js-header-nav-item hm-nav-link d-flex flex-center">';

            // 显示图标
            if ($navLink->displayIcon($link)) {
                if ('image' == $link['icon']) {
                    $html .= '<img class="hm-nav-icon" src="' . $link['image'] . '">';
                } elseif ('font' == $link['icon']) {
                    $html .= '<i class="hm-nav-icon ' . $link['font'] . '"></i>';
                } else {
                    $html .= '<i class="hm-nav-icon iconfont">' . $link['customFont'] . '</i>';
                }
            }

            // 显示文本
            if ($navLink->displayText($link)) {
                $html .= $link['name'];
            }

            $html .= '</a>';

            // 渲染子链接
            if ($link['subLinks']) {
                $html .= '<dl class="hm-nav-menu">';
                foreach ($link['subLinks'] as $subLink) {
                    $html .= '<dd><a href="' . $this->linkTo->getUrl($subLink['linkTo']) . '">';
                    $html .= $subLink['name'] . '</a></dd>';
                }
                $html .= '</dl>';
            }
        }

        return $html;
    }

    public function afterSave()
    {
        parent::afterSave();
        $this->refreshCache();
    }

    public function afterDestroy()
    {
        parent::afterDestroy();
        $this->refreshCache();
    }

    /**
     * Repo: 获取导航类型
     */
    public function getTypes()
    {
        $types = [];
        wei()->event->trigger('navGetTypes', [&$types]);

        return $types;
    }

    /**
     * 展示链接列表导航
     *
     * @param Nav $nav
     */
    public function displayLink(self $nav)
    {
        $links = $nav->getLinks();
        $this->view->display('@nav/navs/link.php', ['links' => $links]);
    }

    /**
     * Repo: 展示头部导航
     *
     * @param array $nav
     * @param string|null $title
     */
    public function displayHeader(array $nav, $title = null)
    {
        $links = $this->groupBySide($nav['links']);
        $this->view->display('@nav/navs/header.php', [
            'nav' => $nav,
            'title' => $title,
            'leftLinks' => $this->renderLinks($links['left']),
            'rightLinks' => $this->renderLinks($links['right']),
        ]);
    }

    /**
     * 展示底部导航
     *
     * @param array $nav
     */
    public function displayFooter(array $nav)
    {
        $links = [];
        $matched = false;
        foreach ($nav['links'] as $link) {
            $url = $this->linkTo->getUrl($link['linkTo']);
            $isMatch = $matched ? false : $this->isMatch($url);
            $links[] = $link + [
                    'url' => $url,
                    'isMatch' => $isMatch,
                ];
        }

        $this->view->display('@nav/navs/footer.php', get_defined_vars());
    }

    public function isMatch($url)
    {
        // 1. 匹配完整的地址
        $curPath = $this->request->getBaseUrl() . $this->request->getPathInfo();
        if ($curPath == $url) {
            return true;
        }

        // TODO 移除该兼容
        $match = wei()->urlMapper->matchMap($url, $curPath);
        if ($match) {
            return true;
        }

        // TODO 还需支持域名匹配
        // 2. 匹配查询参数
        $parts = parse_url($url);
        if ($parts['path'] !== $curPath) {
            return false;
        }

        parse_str($parts['query'], $queries);
        if (!$queries) {
            return false;
        }

        if (count(array_intersect($queries, $this->request->getQueries())) === count($queries)) {
            return true;
        }

        return false;
    }

    /**
     * Repo: 根据左右位置分组链接
     *
     * @param NavLink $links
     * @return array
     */
    protected function groupBySide($links)
    {
        $data = ['left' => [], 'right' => []];

        /** @var NavLink $link */
        foreach ($links as $link) {
            $data[$link['side']][] = $link;
        }

        return $data;
    }

    /**
     * @return string
     */
    protected function getRenderCacheKey()
    {
        return 'nav' . wei()->app->getId();
    }
}
