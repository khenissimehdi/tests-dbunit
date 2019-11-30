<?php

namespace Tests\DB;

use DB\MyPDO;
use PDO;
use PHPUnit\Framework\TestCase;

class MyPDOTest extends TestCase
{
    public function testInstance()
    {
        $this->expectException(\Exception::class);
        MyPDO::getInstance();
    }

    /**
     * @depends testInstance
     */
    public function testConfiguration()
    {
        MyPDO::setConfiguration('sqlite::memory');
        $this->assertThat(MyPDO::getInstance(), $this->isInstanceOf(PDO::class));
    }

    /**
     * @depends testConfiguration
     */
    public function testSuccessive()
    {
        $this->assertSame(MyPDO::getInstance(), MyPDO::getInstance());
    }

    /**
     * @depends testSuccessive
     */
    public function testDriver()
    {
        $pdo = MyPDO::getInstance();
        $this->assertSame($pdo->getAttribute(PDO::ATTR_DRIVER_NAME), 'sqlite');
    }
}
