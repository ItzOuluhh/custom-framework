<?php

namespace Cloudstorage\Core;

class FileCache implements CacheInterface
{
    protected $cacheDir;

    public function __construct($cacheDir = __DIR__ . '/../storage/cache')
    {
        $this->cacheDir = $cacheDir;
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function get($key)
    {
        $filePath = $this->cacheDir . '/' . md5($key);
        if (!file_exists($filePath)) {
            return null;
        }

        $data = json_decode(file_get_contents($filePath), true);

        if (time() > $data['expires']) {
            unlink($filePath);
            return null;
        }

        return $data['value'];
    }

    public function set($key, $value, $ttl = 3600)
    {
        $filePath = $this->cacheDir . '/' . md5($key);
        $data = [
            'value' => $value,
            'expires' => time() + $ttl,
        ];
        file_put_contents($filePath, json_encode($data));
    }

    public function delete($key)
    {
        $filePath = $this->cacheDir . '/' . md5($key);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function clear()
    {
        foreach (glob($this->cacheDir . '/*') as $file) {
            unlink($file);
        }
    }
}
