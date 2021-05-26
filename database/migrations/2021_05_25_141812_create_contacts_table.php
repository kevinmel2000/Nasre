<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('customer_id')->unsigned();
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('email', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->string('whatsapp', 191)->nullable();
			$table->string('personal_id', 191)->nullable();
			$table->string('birth_date', 191)->nullable();
			$table->enum('gender', array('male','female','other'))->nullable()->default('male');
			$table->timestamps();

			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}

}
