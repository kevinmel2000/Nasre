<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarineLookupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('marine_lookup', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 100);
			$table->string('shipname', 100);
			$table->string('owner', 100)->nullable();
			$table->integer('grt')->default(0);
			$table->integer('dwt')->default(0);
			$table->integer('nrt')->default(0);
			$table->integer('power')->default(0);
			$table->string('ship_year', 100)->nullable();
			$table->string('repair_year', 100)->nullable();
			$table->string('galangan', 100)->nullable();
			$table->integer('ship_type_id')->nullable()->index('marine_lookup_FK');
			$table->integer('classification_id')->nullable()->index('marine_lookup_FK_1');
			$table->integer('construction_id')->nullable()->index('marine_lookup_FK_2');
			$table->timestamps();
			$table->integer('country_id')->nullable()->index('marine_lookup_FK_3');

			$table->foreign('ship_type_id')->references('id')->on('ship_type')->onDelete('restrict');
			$table->foreign('classification_id')->references('id')->on('classification')->onDelete('restrict');
			$table->foreign('construction_id')->references('id')->on('construction')->onDelete('restrict');
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
		Schema::drop('marine_lookup');
	}

}
