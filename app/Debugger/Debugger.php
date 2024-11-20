<?php

namespace Cloudstorage\App\Debugger;

class Debugger
{
    protected static $logFile;

    public static function init($logFile = __DIR__ . '/../Logs/debug.log')
    {
        self::$logFile = $logFile;

        if (!file_exists(self::$logFile)) {
            file_put_contents(self::$logFile, '');
        }
    }

    public static function log($message)
    {
        $timeStamp = date('Y-m-d H:i:s');
        file_put_contents(self::$logFile, "[$timeStamp] $message" . PHP_EOL, FILE_APPEND);
    }

    public static function dump($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }

    public static function dumpAndDie($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die;
    }

    public static function error($message)
    {
        self::log("Error: $message");
        http_response_code(500);
        echo "Er is een fout opgetreden. Neem contact op met de beheerder.";
        die;
    }
}
