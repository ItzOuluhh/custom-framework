<?php

namespace Cloudstorage\Core;

abstract class Middleware
{
    abstract public function handle($request, $next);
}
