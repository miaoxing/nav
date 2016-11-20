<?php

namespace Miaoxing\Nav\Controller\Admin;

class Navs extends \miaoxing\plugin\BaseController
{
    protected $controllerName = '导航管理';

    protected $actionPermissions = [
        'index' => '列表',
        'create' => '添加',
        'edit,update' => '编辑',
        'destroy' => '删除',
    ];

    public function indexAction($req)
    {
        switch ($req['_format']) {
            case 'json':
                $data = [];

                $types = wei()->nav->getTypes();

                foreach ($types as $key => $type) {
                    // 如果不存在导航,创建一个新的
                    $nav = wei()->nav()->curApp()->findOrInit(['type' => $key]);
                    if ($nav->isNew()) {
                        $nav->setAppId()->save([
                            'enable' => false,
                        ]);
                    }

                    $data[] = $nav->toArray() + [
                            'typeConfig' => $type,
                        ];
                }

                return $this->suc([
                    'message' => '读取列表成功',
                    'data' => $data,
                    'page' => $req['page'],
                    'rows' => $req['rows'],
                    'records' => count($data),
                ]);

                break;

            default:
                return get_defined_vars();
                break;
        }
    }

    public function createAction($req)
    {
        return $this->updateAction($req);
    }

    public function editAction($req)
    {
        $nav = wei()->nav()->curApp()->findId($req['id']);

        return get_defined_vars();
    }

    public function updateAction($req)
    {
        $nav = wei()->nav()->curApp()->findId($req['id']);
        $nav->save($req);

        return $this->suc();
    }

    public function destroyAction($req)
    {
        $nav = wei()->nav()->curApp()->findOneById($req['id']);
        $nav->destroy();

        return $this->suc();
    }
}