<?php

namespace Cloudstorage\App\Processors;

use Cloudstorage\Core\ProcessorInterface;

class InputProcessor implements ProcessorInterface
{
    public function process($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags(trim($value)));
        }
        return $data;
    }
}
