<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstimatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();
            $table->string('estimate_number')->nullable();
            $table->string('estimate_title')->nullable();
            $table->bigInteger('estimate_owner_id')->comment('Select the name of the user to whom the estimate is assigned'); // Select the name of the user to whom the estimate is assigned.
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('billing_address_id')->nullable();
            $table->bigInteger('shipping_address_id')->nullable();
            $table->string('estimate_date')->nullable();
            $table->string('due_date')->nullable();
            $table->bigInteger('currency_id')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->string('discount_total')->nullable();
            $table->string('total_amount')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('adjustments')->nullable();
            $table->enum('status',['draft', 'sent', 'open', 'revised', 'declined'])->default('draft');
            $table->string('payment_options')->nullable();
            $table->string('shipping_charges')->nullable();
            $table->string('due_terms')->nullable();
            $table->text('customer_notes')->nullable();
            $table->text('termsandconditions')->nullable();
            $table->string('mail_to')->nullable();
            $table->enum('email_send',['yes', 'no'])->default('no');
            $table->string('invoiced_token')->nullable();
            $table->enum('is_invoiced',['yes', 'no'])->default('no');
            $table->string('recurring_estimates')->nullable();
            $table->string('file_1')->nullable();
            $table->string('file_2')->nullable();
            $table->string('file_3')->nullable();
            $table->string('file_4')->nullable();
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
        Schema::dropIfExists('estimates');
    }
}
