<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtendedCoverageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('extended_coverage', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 100)->nullable();
			$table->string('name', 100)->nullable();
			$table->text('description')->nullable();
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
		Schema::drop('extended_coverage');
	}

}
