<?php

namespace Miaoxing\Nav\Migration;

use Miaoxing\Plugin\BaseMigration;

class V20161120150627CreateNavsTables extends BaseMigration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->scheme->table('navs')
            ->id()
            ->int('appId')
            ->string('type', 16)->comment('导航的类型')
            ->string('name', 32)
            ->string('position', 8)->comment('显示位置top,bottom等')
            ->string('color', 8)->comment('文字颜色')
            ->string('bgColor', 8)->comment('背景颜色')
            ->string('activeColor', 8)->comment('激活时的颜色')
            ->string('display')->comment('显示图标的类型')
            ->bool('enable')->defaults(1)->comment('是否启用')
            ->timestamps()
            ->int('createUser')
            ->int('updateUser')
            ->exec();

        $this->scheme->table('navLinks')
            ->id()
            ->int('navId')
            ->int('parentId')->comment('父链接编号')
            ->tinyInt('type', 1)->defaults(1)->comment('1链接 2分隔线')
            ->string('name', 32)->comment('名称')
            ->string('icon', 16)->defaults('font')->comment('图标类型,可以是image,font或custom-font')
            ->string('image')->comment('图片')
            ->string('font')->comment('图标字体的类名')
            ->string('customFont', 32)
            ->string('bgColor', 8)
            ->string('display', 8)->comment('all, icon, text')
            ->string('side', 8)->defaults('right')->comment('显示位置 left right')
            ->text('linkTo')
            ->smallInt('sort', 6)->comment('顺序')
            ->text('description')->comment('描述')
            ->timestamps()
            ->int('createUser')
            ->int('updateUser')
            ->exec();
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->scheme->dropIfExists('navs');
        $this->scheme->dropIfExists('navLinks');
    }
}
