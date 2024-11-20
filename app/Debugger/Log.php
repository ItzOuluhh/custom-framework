<?php

namespace Cloudstorage\App\Debugger;

class Log
{
    protected static $logFile;

    public static function init($logFile = __DIR__ . '/../logs/error.log')
    {
        self::$logFile = $logFile;

        if (!file_exists(self::$logFile)) {
            file_put_contents(self::$logFile, '');
        }
    }

    public static function error($message)
    {
        $timeStamp = date('Y-m-d H:i:s');
        file_put_contents(self::$logFile, "[$timeStamp] Error: $message" . PHP_EOL, FILE_APPEND);
    }
}
