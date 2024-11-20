<?php

namespace Cloudstorage\ORM;

use PDO;
use PDOException;

class Model
{
    protected $table;
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
    }

    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $keys = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($keys) VALUES ($values)");
        return $stmt->execute($data);
    }
}
