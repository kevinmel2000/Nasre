<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();          // Staff ID - if NUll, then show Admin added
            $table->string('title_id')->nullable();             // Lead title ID
            $table->string('language_id')->nullable();          // Language ID
            $table->string('first_name')->nullable();           // Person Name
            $table->string('last_name')->nullable();            // Person Name
            $table->string('company_name')->nullable();         // Company Name
            $table->string('website')->nullable();              // Website
            $table->string('email')->nullable();
            $table->string('email_opt_out')->nullable();
            $table->string('fax')->nullable();
            $table->string('fax_opt_out')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('phone_opt_out')->nullable();
            $table->string('prospect_status')->nullable();      // Prospect Status
            $table->string('owner_id')->nullable();             // lead owner ID, who created the lead 
            $table->string('last_owner_id')->nullable();        // last lead owner ID, if owner changed     
            $table->string('industry_id')->nullable();         
            $table->string('last_transfer_date')->nullable();   // The date the lead owner was last changed.
            $table->string('lead_source_id')->nullable();       // lead source ID, like website , fb, twitter
            $table->string('lead_status_id')->nullable();       // lead status ID
            $table->string('lead_temprature')->nullable();      // hot, warm, cold
            $table->string('score')->nullable();                // 1 to 10 score
            $table->enum('read_status',['yes', 'no'])->default('no');// if lead has been viewed and marked as acted
            $table->enum('is_dead',['yes', 'no'])->default('no');
            $table->enum('is_poor_fit',['yes', 'no'])->default('no');
            $table->string('win_time')->nullable();
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
        Schema::dropIfExists('leads');
    }
    
}
