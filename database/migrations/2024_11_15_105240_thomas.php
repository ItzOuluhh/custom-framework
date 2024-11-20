<?php

namespace Cloudstorage\App\Migrations;

use Cloudstorage\Core\Schema;
use Cloudstorage\Core\Blueprint;
use Cloudstorage\Core\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create("Thomas", function (Blueprint $table) {
            $table->id();
            $table->string("first_name");
            $table->string("last_name");
            $table->timestamps();
        });

        // Add your migration code here
    }

    public function down()
    {
        Schema::dropIfExists("Thomas");

        // Add your rollback code here
    }
};
