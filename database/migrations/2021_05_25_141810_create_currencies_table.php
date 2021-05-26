<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('symbol_name', 191);
			$table->enum('is_base_currency', array('yes','no'))->default('no');
			$table->timestamps();
			$table->string('code', 10);
			$table->integer('country')->index('currencies_FK');

			$table->foreign('country')->references('id')->on('countries')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('currencies');
	}

}
