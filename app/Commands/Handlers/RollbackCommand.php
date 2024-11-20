<?php

namespace Cloudstorage\App\Commands\Handlers;

use Cloudstorage\App\Commands\Command;
use Cloudstorage\Core\Database;
use Cloudstorage\Core\Migration;

class RollbackCommand extends Command
{
    public function getName(): string
    {
        return 'migrate:rollback';
    }

    public function getDescription(): string
    {
        return 'Execute all rollbacks.';
    }

    public function execute(array $args)
    {
        $db = Database::getConnection();

        $stmt = $db->query("SELECT migration_name FROM migrations ORDER BY created_at DESC LIMIT 1");
        $migrationName = $stmt->fetchColumn();

        if ($migrationName) {
            $filePath = __DIR__ . "/../../../database/migrations/{$migrationName}.php";

            if (file_exists($filePath)) {
                $migrationClass = require $filePath;

                if ($migrationClass instanceof Migration) {
                    $migrationClass->down();

                    $stmt = $db->prepare("DELETE FROM migrations WHERE migration_name = ?");
                    $stmt->execute([$migrationName]);

                    echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
                    echo "Rolled back migration: {$migrationName}\n";
                    echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
                } else {
                    echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
                    echo "Invalid migration file: {$filePath}\n";
                    echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
                }
            } else {
                echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
                echo "Migration file not found: {$migrationName}\n";
                echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
            }
        } else {
            echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
            echo "No migrations found to rollback.\n";
            echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
        }
    }
}
