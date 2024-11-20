<?php

namespace Cloudstorage\App\Migrations;

use Cloudstorage\Core\Schema;
use Cloudstorage\Core\Blueprint;
use Cloudstorage\Core\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create("Debug", function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email", 255, true);
            $table->string("password");
            $table->string("profile_picture");
            $table->timestamps();
        });

        // Add your migration code here
    }

    public function down()
    {
        Schema::dropIfExists("Debug");

        // Add your rollback code here
    }
};
