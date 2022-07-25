<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .
'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\ItemsTable;
use \SQLite3;

class ItemsTableTest extends TestCase
{
    protected $pdo;
    protected $itemsTable;

    public function setUp()
    {
        $this->pdo = $this->getConnection();
        $this->createTable();
        $this->populateTable();

        $this->itemsTable = new ItemsTable($this->pdo);
    }

    public function tearDown()
    {
        unset($this->itemsTable);
        unset($this->pdo);
    }

    public function testFindForId()
    {
        $id = 1;
        $result = $this->itemsTable->findForId($id);
        
        $this->assertInternalType(
            'array', 
            $result,
            'The result should always be array.'
        );

        $this->assertEquals(
            $id,
            $result['id'],
            'The id should equal the test id.'
        );

        $this->assertEquals(
            'Candy',
            $result['name'],
            'The name should be Candy.'
        );
    }

    public function getConnection()
    {
        $db_name = "gustavo";

        return new SQLite3($db_name);
    }

    public function createTable()
    {
        $query = "
            DROP TABLE IF EXISTS gustavo.`items`;
            CREATE TABLE `items` (
                `id` INTEGER,
                `name` TEXT,
                `price` REAL,
                PRIMARY KEY(`id`)
            );
        ";
        $this->pdo->exec($query);
    }

    public function populateTable()
    {
        $query = "
            INSERT INTO `items` VALUES (1, 'Candy', 1.00),
            (2, 'Tshirt', 5.34)
        ";
        $this->pdo->exec($query);
    }
}