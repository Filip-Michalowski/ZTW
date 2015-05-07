<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatUserPortyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gracz_porty', function(Blueprint $table)
		{
			$table->integer('gracz_id')->unsigned();
			$table->integer('port_id')->unsigned();
			$table->rememberToken();
			$table->timestamps();

			$table->foreign('gracz_id')
				  ->references('id')
				  ->on('users');

			$table->foreign('port_id')
				  ->references('id')
				  ->on('porty');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gracz_porty');
	}

}
