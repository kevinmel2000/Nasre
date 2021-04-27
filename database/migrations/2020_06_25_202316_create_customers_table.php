<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();             // Contact user ID for login
            $table->string('password')->nullable();             // Password
            $table->string('company_name')->nullable();     // Company Name
            $table->string('customer_type')->nullable();        // Customer Type
            $table->string('prospect_status')->nullable();      // Prospect Status
            $table->string('campaign_id')->nullable();          // Campaign ID
            $table->string('owner_id')->nullable();             // Owner - Who created the Lead or Customer
            $table->string('industry_id')->nullable();
            $table->string('vat_number')->nullable();       // VAT number
            $table->string('website')->nullable();          // website
            $table->timestamp('success_timestamp')->nullable(); // Time, when lead converted into customer
            $table->string('password_reset_token')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
