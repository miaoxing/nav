<?php

namespace Miaoxing\Nav;

class Plugin extends \Miaoxing\Plugin\BasePlugin
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
        $this->view->display('@nav/nav/style.php');
    }

    public function onBodyStart($pageConfig, $title)
    {
        wei()->nav->display($pageConfig, $title);
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
