<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipPortTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ship_port', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 100)->nullable();
			$table->string('name', 100)->nullable();
			$table->text('description')->nullable();
			$table->integer('city_id')->unsigned();
			$table->timestamps();

			// $table->foreign('cities_id')->references('id')->on('cities')->onDelete('restrict');
			

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ship_port');
	}

}
