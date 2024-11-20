<?php

namespace Cloudstorage\App\Controllers;

use Cloudstorage\App\Models\User;
use Cloudstorage\Core\Request;
use Cloudstorage\Core\Response;

class DashboardController
{
    public function showDashboard()
    {
        return view('Index@Dashboard');
    }
}
