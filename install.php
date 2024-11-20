<?php

echo "Starting installation...\n";

require_once __DIR__ . '/vendor/autoload.php'; // Zorg dat autoload werkt

use Cloudstorage\Core\Database;

// 1. Kopieer de `.env.example` naar `.env` als deze nog niet bestaat
$envPath = __DIR__ . '/.env';
$envExamplePath = __DIR__ . '/.env.example';

if (!file_exists($envPath)) {
    if (file_exists($envExamplePath)) {
        copy($envExamplePath, $envPath);
        echo "✅ .env file created from .env.example.\n";
    } else {
        die("❌ .env.example not found. Please create it first.\n");
    }
} else {
    echo "⚠️ .env file already exists. Skipping this step.\n";
}

// 2. Vraag om databasegegevens en schrijf deze naar de .env file
echo "Please enter your database details:\n";

$dbHost = readline("Database Host (default: localhost): ") ?: 'localhost';
$dbName = readline("Database Name: ");
$dbUser = readline("Database Username: ");
$dbPass = readline("Database Password: ");

$envContent = file_get_contents($envPath);
$envContent = str_replace(
    ['DB_HOST=localhost', 'DB_DATABASE=', 'DB_USERNAME=', 'DB_PASSWORD='],
    ["DB_HOST=$dbHost", "DB_DATABASE=$dbName", "DB_USERNAME=$dbUser", "DB_PASSWORD=$dbPass"],
    $envContent
);
file_put_contents($envPath, $envContent);

echo "✅ Database configuration written to .env file.\n";

// 3. Database verbinding testen en basis-migraties uitvoeren
try {
    $db = Database::getConnection();
    echo "✅ Database connection successful.\n";

    // 4. Maak de migraties tabel aan als die nog niet bestaat
    $db->exec("CREATE TABLE IF NOT EXISTS migrations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        migration_name VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✅ Migrations table created.\n";

    // 5. Draai alle migraties
    echo "Starting migrations...\n";
    $migrationsPath = __DIR__ . '/database/migrations/';
    $migrationFiles = glob($migrationsPath . '*.php');

    foreach ($migrationFiles as $file) {
        $migrationName = basename($file, '.php');
        $stmt = $db->prepare("SELECT * FROM migrations WHERE migration_name = ?");
        $stmt->execute([$migrationName]);

        if (!$stmt->fetch()) {
            require $file;
            echo "✔️ Migrated: $migrationName\n";

            // Voeg de migration toe aan de database
            $stmt = $db->prepare("INSERT INTO migrations (migration_name) VALUES (?)");
            $stmt->execute([$migrationName]);
        } else {
            echo "⚠️ Migration $migrationName already applied. Skipping...\n";
        }
    }
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage() . "\n");
}

echo "✅ Installation completed successfully.\n";
