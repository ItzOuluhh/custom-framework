<?php

namespace Cloudstorage\App\Migrations;

use Cloudstorage\Core\Schema;
use Cloudstorage\Core\Blueprint;
use Cloudstorage\Core\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create("Users", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email", 255, true);
            $table->string("password");
            $table->timestamps();
        });

        // Add your migration code here
    }

    public function down()
    {
        Schema::dropIfExists("Users");

        // Add your rollback code here
    }
};
