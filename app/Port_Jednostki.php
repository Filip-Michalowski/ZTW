<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Port_Jednostki extends Model {

	protected $table = 'port_jednostki';

	public function jednostka() {
		return $this->belongsTo('App\Jednostka');
	}

	public function port() {
		return $this->belongsTo('App\Port');
	}
}
