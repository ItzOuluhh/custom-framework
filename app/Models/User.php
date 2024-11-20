<?php

namespace Cloudstorage\App\Models;

use Cloudstorage\Core\Model;

class User extends Model
{
    protected static $table = 'Users';

    public function findByEmail($email)
    {
        return $this->where('email', $email);
    }
}
