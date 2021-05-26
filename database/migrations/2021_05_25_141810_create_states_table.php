<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('states', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 30);
			$table->integer('country_id')->default(1);
			$table->string('code', 100)->nullable();
			$table->string('kepulauan_code', 100)->nullable();

			$table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('states');
	}

}
