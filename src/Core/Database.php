<?php

namespace Cloudstorage\Core;

use PDO;
use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (self::$connection === null) {
            $dsn = $_ENV['DB_DSN'];
            $username = $_ENV['DB_USER'];
            $password = $_ENV['DB_PASSWORD'];

            self::$connection = new PDO($dsn, $username, $password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }
}
