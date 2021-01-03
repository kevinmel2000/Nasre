<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('role_id');
            $table->string('module_name'); // module names are defined in the constants file.
            $table->enum('create',  ['on', 'off'])->default('off');
            $table->enum('read',    ['on', 'off'])->default('off');
            $table->enum('update',  ['on', 'off'])->default('off');
            $table->enum('delete',  ['on', 'off'])->default('off');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
}
