<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('porty', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nazwa');
			$table->integer('gracz_id')->unsigned();
			$table->timestamps();

			$table->foreign('gracz_id')
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
		Schema::drop('porty');
	}

}
