<?php

namespace Cloudstorage\Core;

class ProcessorManager
{
    private static $processors = [];

    public static function registerProcessor($name, ProcessorInterface $processor)
    {
        self::$processors[$name] = $processor;
    }

    public static function process($name, $data)
    {
        if (isset(self::$processors[$name])) {
            return self::$processors[$name]->process($data);
        }
        return $data;
    }
}
