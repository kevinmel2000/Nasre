<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRouteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('route', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 100)->nullable();
			$table->string('name', 100)->nullable();
			$table->text('description')->nullable();
			$table->integer('from')->nullable();
			$table->integer('to')->nullable();
			$table->integer('transit_1')->nullable();
			$table->integer('transit_2')->nullable();
			$table->timestamps();

			$table->foreign('from')->references('id')->on('ship_port')->onDelete('restrict');
			$table->foreign('to')->references('id')->on('ship_port')->onDelete('restrict');
			$table->foreign('transit_1')->references('id')->on('ship_port')->onDelete('restrict');
			$table->foreign('transit_2')->references('id')->on('ship_port')->onDelete('restrict');

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('route');
	}

}
