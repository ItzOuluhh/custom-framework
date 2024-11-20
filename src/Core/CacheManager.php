<?php

namespace Cloudstorage\Core;

class CacheManager
{
    private static $cache;

    public static function init(CacheInterface $cache)
    {
        self::$cache = $cache;
    }

    public static function get($key)
    {
        return self::$cache->get($key);
    }

    public static function set($key, $value, $ttl = 3600)
    {
        self::$cache->set($key, $value, $ttl);
    }

    public static function delete($key)
    {
        self::$cache->delete($key);
    }

    public static function clear()
    {
        self::$cache->clear();
    }
}
