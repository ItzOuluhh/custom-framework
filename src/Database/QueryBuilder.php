<?php

namespace Cloudstorage\Database;

use PDO;

class QueryBuilder
{
    protected string $table;
    protected PDO $pdo;

    public function __construct($table, DB $db)
    {
        $this->table = $table;
        $this->pdo = $db->getPdo();
    }

    public function insert(array $data)
    {
        $columns = implode(", ", array_keys($data[0]));
        $placeholders = implode(", ", array_map(fn($col) => ":$col", array_keys($data[0])));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $row) {
            foreach ($row as $column => $value) {
                $stmt->bindValue(":$column", $value);
            }
            $stmt->execute();
        }
    }
}
