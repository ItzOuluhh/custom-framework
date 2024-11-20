<?php

namespace Cloudstorage\Core\Utils;

class DateHelper
{
    public static function now($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }

    public static function format($date, $format = 'Y-m-d')
    {
        return date($format, strtotime($date));
    }
}
