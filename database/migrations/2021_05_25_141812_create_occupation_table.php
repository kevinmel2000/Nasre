<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccupationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('occupation', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 10);
			$table->string('description', 350)->nullable();
			$table->string('abbreviation', 350);
			$table->string('group_type', 100)->nullable();
			$table->integer('parent_id')->nullable();
			$table->integer('cob_id')->index('occupation_FK');
			$table->timestamps();
			$table->decimal('rate_batas_bawah_building_class_1', 10, 3)->nullable();
			$table->decimal('rate_batas_atas_building_class_1', 10, 3)->nullable();
			$table->decimal('rate_batas_bawah_building_class_2', 10, 3)->nullable();
			$table->decimal('rate_batas_atas_building_class_2', 10, 3)->nullable();
			$table->decimal('rate_batas_bawah_building_class_3', 10, 3)->nullable();
			$table->decimal('rate_batas_atas_building_class_3', 10, 3)->nullable();

			$table->foreign('cob_id')->references('id')->on('cob')->onDelete('restrict');

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('occupation');
	}

}
