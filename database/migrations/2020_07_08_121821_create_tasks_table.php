<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('start_date')->nullable();

            $table->bigInteger('owner_id')->nullable();
            $table->enum('type',['Email', 'Call', 'Follow up', 'Meeting', 'Letter', 'Event'])->default('Email');
            $table->enum('status',['Waiting' ,'Started', 'In progress', 'Completed', 'Rejected'])->default('Waiting');
            $table->text('description')->nullable();
            $table->enum('relation',['Customer','Lead'])->default('Customer');
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('lead_id')->nullable();
            $table->enum('priority',['High', 'Med', 'Low'])->default('High');
            $table->enum('send_notifications',['yes', 'no'])->default('yes');
            $table->enum('is_all_day',['yes', 'no'])->default('no');
            $table->string('start_time')->nullable(); // task start time
            $table->string('end_time')->nullable();   // task end time
            $table->string('task_time')->nullable();   // total task time
            $table->enum('billable',['yes', 'no'])->default('no');
            $table->string('bill_amount')->nullable();
            $table->string('estimated_time')->nullable();
            $table->enum('repeat_task',['yes', 'no'])->default('no');
            $table->enum('repeat_every',['none','week','day', 'month', 'year'])->default('day');
            $table->string('repeat_day_month')->nullable()->comment('specific day of the month');
            $table->string('end_date')->nullable();
            $table->bigInteger('created_by_id')->nullable()->comment('one who created this data');
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
        Schema::dropIfExists('tasks');
    }
}
