<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->enum('relation',['Customer', 'Lead'])->default('Customer');
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('lead_id')->nullable();
            $table->string('proposal_date')->nullable();
            $table->string('open_till_date')->nullable();
            $table->bigInteger('currency_id')->nullable();

            $table->enum('status',['draft', 'sent', 'open', 'revised', 'declined', 'accepted'])->default('draft');
            $table->bigInteger('assigned_to')->nullable()->comment('staff user id');
            $table->string('mail_to')->nullable();
            $table->text('message')->nullable();
            
            // Products related fields
            $table->string('sub_total')->nullable()->comment('price without taxes');
            $table->enum('discount_type',['Before Tax', 'After Tax'])->default('Before Tax');
            $table->string('discountTotal')->nullable();
            $table->string('total_discount_percentage')->nullable();
            $table->string('adjustments')->nullable();
            $table->string('totalAmount')->nullable()->comment('per product amount');
            $table->bigInteger('created_by_id')->nullable();
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
        Schema::dropIfExists('proposals');
    }
}
