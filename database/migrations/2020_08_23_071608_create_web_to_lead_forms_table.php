<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebToLeadFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_to_lead_forms', function (Blueprint $table) {
            $table->id();
            $table->text('formdata')->nullable();
            $table->string('title')->nullable();
            $table->string('heading')->nullable();
            $table->text('note')->nullable();
            $table->text('token')->nullable();
            $table->text('returnurl')->nullable();
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
        Schema::dropIfExists('web_to_lead_forms');
    }
}
