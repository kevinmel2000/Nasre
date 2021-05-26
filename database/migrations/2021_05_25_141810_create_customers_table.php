<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('username', 191)->nullable();
			$table->string('password', 191)->nullable();
			$table->string('company_name', 191)->nullable();
			$table->string('website', 191)->nullable();
			$table->timestamps();
			$table->string('company_prefix', 100)->nullable();
			$table->string('company_suffix', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customers');
	}

}
