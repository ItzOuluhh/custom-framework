<?php

namespace Cloudstorage\App\Commands\Handlers;

use Cloudstorage\App\Commands\Command;
use Cloudstorage\Core\Database;

class MigrateCommand extends Command
{
    public function getName(): string
    {
        return 'migrate';
    }

    public function getDescription(): string
    {
        return 'Execute all migrations.';
    }

    public function execute(array $args)
    {
        $db = Database::getConnection();

        $migrationsPath = __DIR__ . '/../../../database/migrations/';
        $migrationFiles = glob($migrationsPath . '*.php');

        if (empty($migrationFiles)) {
            echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
            echo "No migrations found.\n";
            echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";

            return;
        }

        echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
        foreach ($migrationFiles as $file) {
            $migrationClass = require $file;
            $migrationName = basename($file, '.php');
            $migrationName = str_replace('', '.php', $migrationName);

            $stmt = $db->prepare("SELECT * FROM migrations WHERE migration_name = ?");
            $stmt->execute([$migrationName]);
            $migrationExists = $stmt->fetch();

            if ($migrationExists) {
                continue;
            }

            if ($migrationClass instanceof \Cloudstorage\Core\Migration) {
                $migrationClass->up();

                $stmt = $db->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
                $stmt->execute([$migrationName]);

                echo "Migratie '" . basename($file, '.php') . "' executed successfully.\n";
            } else {
                echo "Migration in file: '{$file}' invalid.\n";
            }
        }
        echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
    }
}
