<?php

namespace Cloudstorage\Core;

class Blueprint
{
    protected $table;
    protected $columns = [];
    protected $uniqueColumns = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function id()
    {
        $this->columns[] = 'id INT AUTO_INCREMENT PRIMARY KEY';
    }

    public function string($name, $length = 255, $unique = false)
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Column name cannot be empty.');
        }

        $columnDefinition = "$name VARCHAR($length)";

        if ($unique) {
            $columnDefinition .= ' UNIQUE';
        }

        $this->columns[] = $columnDefinition;
    }

    public function boolean($name)
    {
        $this->columns[] = "$name BOOLEAN";
    }

    public function text($name)
    {
        $this->columns[] = "$name TEXT";
    }

    public function timestamps()
    {
        $this->columns[] = 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $this->columns[] = 'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
    }

    public function toSql()
    {
        $columnsSql = implode(", ", $this->columns);

        return "CREATE TABLE {$this->table} ($columnsSql)";
    }
}
