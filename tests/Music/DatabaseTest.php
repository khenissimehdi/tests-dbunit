<?php

namespace Tests\Music;

use DB\MyPDO;
use Exception;
use PHPUnit\DbUnit\Database\Connection;
use PHPUnit\DbUnit\DataSet\FlatXmlDataSet;
use PHPUnit\DbUnit\TestCase;

/**
 * Class DatabaseTest.
 */
class DatabaseTest extends TestCase
{
    private static $connection = null;
    private static $dataset = null;

    /**
     * Returns the test database connection.
     *
     * @return Connection
     * @throws Exception
     */
    protected function getConnection()
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

    /**
     * Returns the test dataset.
     *
     * @return FlatXmlDataSet
     */
    protected function getDataSet()
    {
        if (null == self::$dataset) {
            self::$dataset = $this->createFlatXMLDataSet(dirname(__FILE__).'/database/dataset.xml');
        }

        return self::$dataset;
    }
}
