<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesExcTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('currencies_exc', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->bigInteger('currency')->unsigned()->index('currencies_exc_FK');
			$table->integer('month');
			$table->integer('year');
			$table->float('kurs', 10, 0);
			$table->timestamps();

			$table->foreign('currency')->references('id')->on('currencies')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('currencies_exc');
	}

}
