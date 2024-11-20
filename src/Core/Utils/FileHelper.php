<?php

namespace Cloudstorage\Core\Utils;

class FileHelper
{
    public static function read($filePath)
    {
        return file_exists($filePath) ? file_get_contents($filePath) : null;
    }

    public static function write($filePath, $content)
    {
        return file_put_contents($filePath, $content);
    }

    public static function delete($filePath)
    {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
