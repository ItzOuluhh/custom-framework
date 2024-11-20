<?php

namespace Cloudstorage\App\Middleware;

use Cloudstorage\Core\Middleware;

class AuthMiddleware extends Middleware
{
    public function handle($request, $next)
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo "Unauthorized";
            return;
        }

        return $next($request);
    }
}
