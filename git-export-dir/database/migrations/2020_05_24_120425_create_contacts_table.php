<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id')->nullable();
            $table->string('first_name')->nullable();       // Person First Name
            $table->string('last_name')->nullable();        // Person Last Name
            $table->string('email')->nullable();            // Email
            $table->enum('is_primary',['yes', 'no'])->default('no');
            $table->string('title_id')->nullable();         // Title ID
          
            $table->string('phone')->nullable();            // Phone
            $table->string('whatsapp')->nullable();         // Whatsapp Number

            $table->string('language_id')->nullable();      // Customer Language (Show as dropdown)
            
            $table->enum('decision_maker',['yes', 'no'])->default('yes');
            $table->string('personal_id')->nullable();
  
            $table->string('birth_date')->nullable();
            $table->enum('gender',['male', 'female', 'other'])->default('male')->nullable();
            

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
        Schema::dropIfExists('contacts');
    }
}
