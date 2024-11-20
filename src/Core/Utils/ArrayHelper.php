<?php

namespace Cloudstorage\Core\Utils;

class ArrayHelper
{
    public static function get(array $array, $key, $default = null)
    {
        return $array[$key] ?? $default;
    }

    public static function clean(array $array)
    {
        return array_filter($array, fn($value) => !empty($value));
    }
}
