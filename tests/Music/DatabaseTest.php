<?php

namespace Tests\Music;

use DB\MyPDO;
use Exception;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\FlatXmlDataSet;
use PHPUnit\DbUnit\Database\DefaultConnection;
use PHPUnit\DbUnit\DataSet\IDataSet;
use PHPUnit\DbUnit\TestCase;


abstract class DatabaseTest extends TestCase
{


    private static $dataset = null;
    private static $connection = null;


    public function getDataSet(): IDataSet
    {
        if (null == self::$dataset) {
            self::$dataset = $this->createFlatXMLDataSet(dirname(__FILE__).'/database/dataset.xml');
        }

        return self::$dataset;
    }

    public function getConnection()
    {
        if (null == self::$connection) {
            MyPDO::setConfiguration('sqlite::memory:');
            $pdo = MyPDO::getInstance();
            $database = file_get_contents('database/structure.sql');
            $pdo->exec($database);
            self::$connection = $this->createDefaultDBConnection($pdo);
        }

        return self::$connection;
    }


}
