<?php

namespace Cloudstorage\Core;

use Dotenv\Dotenv;

class Config
{
    public static function load()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
    }
}
