<?php

namespace Cloudstorage\Core\Utils;

class StrHelper
{
    public static function toSnakeCase($string)
    {
        return strtolower(preg_replace('/[A-Z]/', '_$0', lcfirst($string)));
    }

    public static function toCamelCase($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }

    public static function slugify($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string), '-'));
    }
}
