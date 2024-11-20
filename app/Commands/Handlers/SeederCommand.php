<?php

namespace Cloudstorage\App\Commands\Handlers;

use Cloudstorage\App\Commands\Command;
use Cloudstorage\Core\Seeder;

class SeederCommand extends Command
{
    public function getName(): string
    {
        return 'seed';
    }

    public function getDescription(): string
    {
        return 'Execute all database seeds.';
    }

    public function execute(array $args)
    {
        $seedersPath = __DIR__ . '/../../../database/seeders/';
        $seederFiles = glob($seedersPath . '*.php');

        if (empty($seederFiles)) {
            echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
            echo "No seeders found.\n";
            echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";

            return;
        }

        echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
        foreach ($seederFiles as $file) {
            require_once $file;
            $seederClassName = 'Cloudstorage\\Database\\Seeders\\' . basename($file, '.php');

            if (class_exists($seederClassName) && is_subclass_of($seederClassName, Seeder::class)) {
                $seeder = new $seederClassName();
                $seeder->run();
                echo "Seeder " . basename($file, '.php') . " success.\n";
            } else {
                echo "Invalid seeder in file: '{$file}'.\n";
            }
        }
        echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
    }
}
