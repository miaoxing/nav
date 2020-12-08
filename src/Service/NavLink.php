<?php

namespace Miaoxing\Nav\Service;

class NavLink extends \Miaoxing\Plugin\BaseService
{
    const TYPE_LINK = 1;

    const TYPE_DIVIDER = 2;

    protected $autoId = true;

    protected $data = [
        'type' => 1,
        'icon' => 'image',
        'linkTo' => [],
        'sort' => 50,
    ];

    protected $table = 'navLinks';

    /**
     * @var NavLink|NavLink[]
     */
    protected $subLinks;

    /**
     * @var NavLink
     */
    protected $parentLink;

    protected $providers = [
        'db' => 'app.db',
    ];

    /**
     * 根据linkTo配置获取对应的地址
     */
    public function getUrl()
    {
        return $this->linkTo->getUrl($this['linkTo']);
    }

    public function getSubLinks()
    {
        $this->subLinks || $this->subLinks = wei()->navLink()->desc('sort')->findAll(['parentId' => $this['id']]);

        return $this->subLinks;
    }

    public function getParentLink()
    {
        $this->parentLink || $this->parentLink = wei()->navLink()->findOrInitById($this['parentId']);

        return $this->parentLink;
    }

    public function displayIcon($link)
    {
        $link || $link = $this;

        return in_array($link['display'], ['icon', 'all']);
    }

    public function displayText($link)
    {
        $link || $link = $this;

        return in_array($link['display'], ['text', 'all']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this['linkTo'] = $this->linkTo->decode($this['linkTo']);
    }

    public function beforeSave()
    {
        parent::beforeSave();
        $this['linkTo'] = $this->linkTo->encode($this['linkTo']);
    }

    public function afterSave()
    {
        parent::afterSave();
        wei()->nav->refreshCache();
    }

    public function afterDestroy()
    {
        parent::afterDestroy();
        wei()->nav->refreshCache();
    }

    public function isDivider()
    {
        return $this['type'] == static::TYPE_DIVIDER;
    }
}
