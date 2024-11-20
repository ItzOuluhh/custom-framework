<?php

namespace Cloudstorage\Core;

abstract class Migration
{
    /**
     * Execute the migration.
     */
    abstract public function up();

    /**
     * Rollback the migration.
     */
    abstract public function down();
}
