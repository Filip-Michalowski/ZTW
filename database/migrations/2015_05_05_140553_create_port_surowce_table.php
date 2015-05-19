<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortSurowceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('port_surowce', function(Blueprint $table)
			{
			$table->integer('port_id')->unsigned();
			$table->integer('surowiec_id')->unsigned();
			
			$table->primary(['port_id', 'surowiec_id']);

			$table->integer('ilosc');

			$table->decimal('rate',10,2);

			$table->integer('magazyn');

			$table->rememberToken();
			$table->timestamps();

			$table->foreign('port_id')
				  ->references('id')
				  ->on('porty');

			$table->foreign('surowiec_id')
				  ->references('id')
				  ->on('surowce');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('port_surowce');
	}

}
