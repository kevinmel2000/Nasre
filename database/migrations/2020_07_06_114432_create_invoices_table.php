<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();
            $table->string('invoice_title')->nullable();
            $table->bigInteger('invoice_owner_id')->comment('Select the name of the user to whom the invoice is assigned'); // Select the name of the user to whom the invoice is assigned.
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('billing_address_id')->nullable();
            $table->bigInteger('shipping_address_id')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('due_date')->nullable();
            $table->bigInteger('currency_id')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->string('discount_total')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('adjustments')->nullable();
            $table->string('amount_due')->nullable();  // total amount due
            $table->string('amount_paid')->nullable(); // amount paid earlier before this invoice
            $table->enum('status',['draft', 'sent', 'open', 'revised', 'declined'])->default('draft');
            $table->enum('invoice_paid',['yes', 'no'])->default('no');// this invoice paid status yes/no
            $table->enum('payment_confirmed',['yes', 'no'])->default('no');// payment confirmed by staff/admin
            $table->bigInteger('payment_mode_id')->nullable(); // payment mode selected by client at the time of invoice payment
            $table->string('payment_time')->nullable();
            $table->string('payment_options')->nullable();
            $table->string('txn_number')->nullable(); // client can enter txn number done by him for the invoice
            $table->string('txn_receipt')->nullable(); // client can upload txn receipt 
            
            $table->string('shipping_charges')->nullable();
            $table->string('due_terms')->nullable();
            $table->text('customer_notes')->nullable();
            $table->text('termsandconditions')->nullable();
            $table->string('mail_to')->nullable();
            $table->enum('email_send',['yes', 'no'])->default('no');
            $table->string('recurring_invoices')->nullable();
            $table->string('file_1')->nullable(); 
            $table->string('file_2')->nullable();
            $table->string('file_3')->nullable();
            $table->string('file_4')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
