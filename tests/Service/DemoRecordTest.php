<?php

namespace MiaoxingTest\Nav\Service;

use Miaoxing\Plugin\Test\BaseTestCase;

/**
 * 演示服务
 */
class NavRecordTest extends BaseTestCase
{
    /**
     * 获取名称
     */
    public function testGetName()
    {
        $this->assertSame('nav', wei()->navRecord->getName());
    }
}
