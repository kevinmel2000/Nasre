<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCobTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cob', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 10);
			$table->string('description', 500);
			$table->string('abbreviation', 100);
			$table->integer('parent_id')->nullable();
			$table->text('remarks')->nullable();
			$table->timestamps();
			$table->string('form', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cob');
	}

}
