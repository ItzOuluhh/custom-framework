<?php

namespace Cloudstorage\Database;

use Cloudstorage\Core\Config;
use PDO;

class DB
{
    protected static PDO $pdo;

    public function __construct()
    {
        Config::load();

        $dsn = $_ENV["DB_DSN"];
        $user = $_ENV["DB_USER"];
        $password = $_ENV["DB_PASSWORD"];

        self::$pdo = new PDO($dsn, $user, $password);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function init($host, $dbname, $username, $password)
    {
        self::$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function table($table)
    {
        return new QueryBuilder($table, new self());
    }

    public function getPdo()
    {
        return self::$pdo;
    }
}
