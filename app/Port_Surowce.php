<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Port_Surowce extends Model {

	protected $table = 'port_surowce';


	public function surowiec() {
		return $this->belongsTo('App\Surowiec');
	}

	public function port() {
		return $this->belongsTo('App\Port');
	}
}
