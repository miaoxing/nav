<?php

namespace Miaoxing\Nav\Controller\Admin;

class Links extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '导航链接管理';

    protected $actionPermissions = [
        'index' => '列表',
        'new,create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];

    public function indexAction($req)
    {
        $nav = wei()->nav()->curApp()->findOneById($req['navId']);

        switch ($req['_format']) {
            case 'json':
                $links = wei()->navLink();

                $links->where([
                    'navId' => $nav['id'],
                    'parentId' => '0',
                ]);

                // 分页
                $links->limit($req['rows'])->page($req['page']);

                // 排序
                $links->desc('side, sort');

                $data = [];
                // 导航
                foreach ($links->findAll() as $link) {
                    $row = [
                        'url' => $link->getUrl(),
                    ];
                    $data[] = $row + $link->toArray();

                    // 子链接
                    foreach ($link->getSubLinks() as $subLink) {
                        $row = [
                            'url' => $subLink->getUrl(),
                        ];
                        $data[] = $row + $subLink->toArray();
                    }
                }

                return $this->suc([
                    'message' => '读取列表成功',
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => $links->count(),
                ]);

            default:
                $types = wei()->nav->getTypes();
                $type = $types[$nav['type']];

                return get_defined_vars();
        }
    }

    public function newAction($req)
    {
        return $this->editAction($req);
    }

    public function editAction($req)
    {
        $link = $this->getLink();

        $types = wei()->nav->getTypes();
        $nav = wei()->nav()->curApp()->findOneById($link['navId']);
        $type = $types[$nav['type']];

        return get_defined_vars();
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function updateAction($req)
    {
        $link = $this->getLink();

        // 确保了navId合法,直接保存即可
        $link->save();

        return $this->suc();
    }

    public function destroyAction($req)
    {
        $link = $this->getLink();

        $link->destroy();

        return $this->suc();
    }

    /**
     * 根据请求参数,获取链接对象,并确保属于当前应用
     *
     * @return \Miaoxing\Nav\Service\NavLink
     */
    public function getLink()
    {
        // Step1 查找出链接
        $link = wei()->navLink()->findId($this->request['id'], $this->request);

        // Step2 验证链接对应的菜单,是否属于当前app
        wei()->nav()->curApp()->findOneById($link['navId']);

        // Step3 如果设置了父链接,检查父链接是否属于当前应用
        if ($link['parentId']) {
            $parentLink = $link->getParentLink();
            wei()->nav()->curApp()->findOneById($parentLink['navId']);
        }

        return $link;
    }
}
