<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKocTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('koc', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('code', 10);
			$table->text('description')->nullable();
			$table->integer('parent_id')->nullable();
			$table->string('abbreviation', 500)->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('koc');
	}

}
