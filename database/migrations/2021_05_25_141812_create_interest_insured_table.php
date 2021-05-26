<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestInsuredTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('interest_insured', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 100)->nullable();
			$table->string('description', 100)->nullable();
			$table->integer('cob_id')->nullable();
			$table->timestamps();

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
		Schema::drop('interest_insured');
	}

}
