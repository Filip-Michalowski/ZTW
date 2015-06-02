<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePocztyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('poczty', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nadawca');
			$table->integer('odbiorca_id')->unsigned();
			$table->string('temat');
			$table->text('tekst');
			$table->timestamp('data')->default(date("Y-m-d H:i:s"));

			$table->foreign('odbiorca_id')
				  ->references('id')
				  ->on('users')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('poczty');
	}

}
