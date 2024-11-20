<?php

namespace Cloudstorage\App\Commands\Handlers;

use Cloudstorage\App\Commands\Command;

class MakeMigrationCommand extends Command
{
    public function getName(): string
    {
        return 'make:migration';
    }

    public function getDescription(): string
    {
        return 'Maak een nieuwe migratie aan.';
    }

    public function execute(array $args)
    {
        if (empty($args[0])) {
            echo "Invalid migration name.\n";
            return;
        }

        $migrationName = $this->formatMigrationName(implode(' ', $args));
        $filePath = __DIR__ . '/../../../database/migrations/' . date('Y_m_d_His') . '_' . $migrationName . '.php';

        $migrationTemplate = '<?php

namespace Cloudstorage\App\Migrations;

use Cloudstorage\Core\Schema;
use Cloudstorage\Core\Blueprint;
use Cloudstorage\Core\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create("", function (Blueprint $table) {
            $table->id();
            $table->string("");
            $table->timestamps();
        });

        // Add your migration code here
    }

    public function down()
    {
        Schema::dropIfExists("");

        // Add your rollback code here
    }
};
';


        file_put_contents($filePath, $migrationTemplate);
        echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
        echo "Migration '{$migrationName}' has been created successfully.\n";
        echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-\n";
    }

    private function formatMigrationName(string $name): string
    {
        $name = preg_replace('/[^A-Za-z0-9\s-]/', '', $name);
        $name = strtolower(trim($name));
        $name = str_replace(' ', '_', $name);

        return $name;
    }
}
