<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJednostkiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jednostki', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nazwa');
			$table->integer('atak')->default(10);
			$table->integer('obrona')->default(10);
			$table->integer('plecak')->default(20);
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
		Schema::drop('jednostki');
	}

}
