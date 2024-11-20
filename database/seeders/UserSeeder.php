<?php

namespace Cloudstorage\Database\Seeders;

use Cloudstorage\Core\Seeder;
use Cloudstorage\Database\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('Tests')->insert([
            [
                'name' => 'John Doe',
                'email' => 'example@example.com',
            ],
            [
                'name' => 'John Doe2',
                'email' => 'example@example.com',
            ],
        ]);
    }
}
