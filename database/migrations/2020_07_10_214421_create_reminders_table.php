<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->string('relation')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('lead_id')->nullable();
            $table->text('description')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->bigInteger('user_id')->nullable()->comment('reminder for this user');
            $table->bigInteger('created_by_id')->nullable()->comment('one who created this data');
            $table->enum('send_email',['yes', 'no'])->default('no');
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
        Schema::dropIfExists('reminders');
    }
}
