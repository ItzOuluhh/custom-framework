<?php

namespace Cloudstorage\Core;

class Response
{
    public static function status($code)
    {
        http_response_code($code);
    }

    public static function json($data, $statusCode = 200)
    {
        self::status($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public static function text($data, $statusCode = 200)
    {
        self::status($statusCode);
        header('Content-Type: text/plain');
        echo $data;
        exit;
    }

    public static function html($data, $statusCode = 200)
    {
        self::status($statusCode);
        header('Content-Type: text/html');
        echo $data;
        exit;
    }

    public static function redirect($url, $statusCode = 302)
    {
        self::status($statusCode);
        header("Location: {$url}");
        exit;
    }

    public static function download($filePath, $fileName = null)
    {
        if (!file_exists($filePath)) {
            self::status(404);
            echo "File not found.";
            exit;
        }

        $fileName = $fileName ?? basename($filePath);
        header('Content-Type: application/octet-stream');
        header("Content-Disposition: attachment; filename={$fileName}");
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}
