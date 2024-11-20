<?php

use Cloudstorage\Core\Route;
use Cloudstorage\App\Controllers\ApiController;

Route::get('/api/data', [ApiController::class, 'getData']);
Route::get('/api/data', [ApiController::class, 'createData']);
