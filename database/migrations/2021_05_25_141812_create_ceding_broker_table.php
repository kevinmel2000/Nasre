<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCedingBrokerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ceding_broker', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 100);
			$table->string('name', 300);
			$table->string('company_name', 350);
			$table->text('address')->nullable();
			$table->integer('country')->index('ceding_broker_FK');
			$table->integer('type');
			$table->timestamps();

			$table->foreign('type')->references('id')->on('company_type')->onDelete('restrict');
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
		Schema::drop('ceding_broker');
	}

}
