<?php

namespace Miaoxing\Nav;

use Miaoxing\Plugin\BasePlugin;
use Miaoxing\Plugin\Service\Layout;

/**
 * @property Layout $layout
 */
class Plugin extends BasePlugin
{
    protected $name = '导航';

    protected $version = '1.0.0';

    protected $description = '显示在前台头部的导航,可以配置二级菜单,设置图标等';

    public function onAdminNavGetNavs(&$navs, &$categories, &$subCategories)
    {
        $navs[] = [
            'parentId' => 'app-site',
            'url' => 'admin/navs',
            'name' => '导航管理',
        ];
    }

    public function onStyle()
    {
        if (!$this->app->isAdmin()) {
            $this->view->display('@nav/nav/style.php');
        }
    }

    public function onBodyStart($title)
    {
        $title || $title = $this->layout->getHeaderTitle();

        wei()->nav->display([
            'displayHeader' => $this->layout->getHeader(),
            'displayFooter' => $this->layout->getFooter(),
        ], $title);
    }

    public function onNavGetTypes(&$types)
    {
        $types['header'] = [
            'name' => '头部导航',
            'scope' => 'page',
            'supports' => [
                'display',
                'side',
                'icons',
                'sub-links',
            ],
        ];

        $types['footer'] = [
            'name' => '底部导航',
            'scope' => 'page',
            'supports' => [
                'icons',
            ],
        ];
    }

    public function onNavRenderHeader($nav, $title)
    {
        wei()->nav->displayHeader($nav, $title);
    }

    public function onNavRenderFooter($nav)
    {
        wei()->nav->displayFooter($nav);
    }
}
