<?php

namespace Cloudstorage\Core;

class Request
{
    public static function all()
    {
        return array_merge($_GET, $_POST);
    }

    public static function input($key, $default = null)
    {
        return $_REQUEST[$key] ?? $default;
    }

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public static function header($key, $default = null)
    {
        $key = strtoupper($key);
        return $_SERVER["HTTP_{$key}"] ?? $default;
    }

    public static function get($key, $default = null)
    {
        return $_GET[$key] ?? $default;
    }

    public static function post($key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }
}
