<?php

namespace Cloudstorage\Core;

interface CacheInterface
{
    public function get($key);
    public function set($key, $value, $ttl = 3600);
    public function delete($key);
    public function clear();
}
