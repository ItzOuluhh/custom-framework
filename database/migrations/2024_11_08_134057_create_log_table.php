<?php

namespace Cloudstorage\App\Migrations;

use Cloudstorage\Core\Schema;
use Cloudstorage\Core\Blueprint;
use Cloudstorage\Core\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::create("Logs", function (Blueprint $table) {
            $table->id();
            $table->string("type_id");
            $table->string("user_id");
            $table->string("output");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists("Logs");
    }
};
