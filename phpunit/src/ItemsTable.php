<?php

namespace TDD;

use \PDO;

class ItemsTable
{
    protected $table = "items";
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function __destruct()
    {
        unset($this->pdo);
    }

    public function findForId($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->table}.id = :id";
        $statment = $this->pdo->prepare($query);
        $statment->bindValue(':id', $id);
        $result = $statment->execute();
        return $result->fetchArray();
    }
}