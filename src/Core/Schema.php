<?php

namespace Cloudstorage\Core;

class Schema
{
    public static function create($table, callable $callback)
    {
        $blueprint = new Blueprint($table);

        $callback($blueprint);

        $sql = $blueprint->toSql();

        $db = Database::getConnection();
        $db->exec($sql);
    }

    public static function duplicate($table, $newTable)
    {
        $sql = "CREATE TABLE $newTable AS SELECT * FROM $table";

        $db = Database::getConnection();
        $db->exec($sql);
    }

    public static function dropIfExists($table)
    {
        $sql = "DROP TABLE IF EXISTS $table";

        $db = Database::getConnection();
        $db->exec($sql);
    }
}
