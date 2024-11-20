<?php

namespace Cloudstorage\Core;

use PDO;

class Model
{
    protected static $table;

    public static function setTable($tableName)
    {
        self::$table = $tableName;
    }

    protected static function getConnection()
    {
        return Database::getConnection();
    }

    public static function all()
    {
        $db = self::getConnection();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data)
    {
        $db = self::getConnection();
        $fields = implode(',', array_keys($data));
        $placeholders = ':' . implode(',:', array_keys($data));
        $stmt = $db->prepare("INSERT INTO " . static::$table . " ($fields) VALUES ($placeholders)");
        return $stmt->execute($data);
    }

    public static function update($id, $data)
    {
        $db = self::getConnection();
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key = :$key, ";
        }
        $set = rtrim($set, ', ');
        $stmt = $db->prepare("UPDATE " . static::$table . " SET $set WHERE id = :id");
        $data['id'] = $id;
        return $stmt->execute($data);
    }

    public static function delete($id)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public static function where($field, $value)
    {
        $db = self::getConnection();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE $field = ?");
        $stmt->execute([$value]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
