<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Cloudstorage\App\Commands\Handlers\MigrateCommand;
use Cloudstorage\App\Commands\Handlers\MakeMigrationCommand;
use Cloudstorage\App\Commands\Handlers\RollbackCommand;
use Cloudstorage\App\Commands\Handlers\SeederCommand;

class CLI
{
    protected $commands = [];

    public function registerCommand($command)
    {
        $this->commands[] = $command;
    }

    public function run($argv)
    {
        if (count($argv) < 2) {
            $this->displayHelp();
            return;
        }

        $command = $argv[1];

        foreach ($this->commands as $cmd) {
            if ($cmd->getName() === $command) {
                $cmd->execute(array_slice($argv, 2));
                return;
            }
        }

        echo "Command '$command' not found.\n";
        $this->displayHelp();
    }

    protected function displayHelp()
    {
        echo "Available commands:\n";
        foreach ($this->commands as $cmd) {
            echo " - " . $cmd->getName() . ": " . $cmd->getDescription() . "\n";
        }
    }
}

$cli = new CLI();

$cli->registerCommand(new MigrateCommand());
$cli->registerCommand(new MakeMigrationCommand());
$cli->registerCommand(new SeederCommand());
$cli->registerCommand(new RollbackCommand());

$cli->run($argv);
