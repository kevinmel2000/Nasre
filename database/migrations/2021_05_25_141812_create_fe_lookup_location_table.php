<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeLookupLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('fe_lookup_location', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('loc_code', 100);
			$table->text('address');
			$table->float('longtitude', 10, 0);
			$table->float('latitude', 10, 0);
			$table->string('postal_code', 100)->nullable();
			$table->integer('city_id')->nullable();
			$table->integer('province_id')->nullable();
			$table->integer('country_id')->nullable()->index('fe_lookup_location_FK');
			$table->integer('eq_zone')->nullable();
			$table->integer('flood_zone')->nullable();
			$table->bigInteger('insured')->unsigned()->nullable();
			$table->timestamps();

			$table->foreign('city_id')->references('id')->on('cities')->onDelete('restrict');
			$table->foreign('province_id')->references('id')->on('states')->onDelete('restrict');
			$table->foreign('country_id')->references('id')->on('countries')->onDelete('restrict');
			$table->foreign('eq_zone')->references('id')->on('earthquake_zone')->onDelete('restrict');
			$table->foreign('flood_zone')->references('id')->on('flood_zone')->onDelete('restrict');
			$table->foreign('insured')->references('id')->on('customers')->onDelete('cascade');

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('fe_lookup_location');
	}

}
