<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArchiwumTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('archiwum', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('nadawca_id')->unsigned();
			$table->string('odbiorca');
			$table->string('temat');
			$table->text('tekst');
			$table->timestamp('data')->default(date("Y-m-d H:i:s"));

			$table->foreign('nadawca_id')
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
		Schema::drop('archiwum');
	}

}
