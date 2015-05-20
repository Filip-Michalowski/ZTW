<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Port_Budynki extends Model {

	protected $table = 'port_budynki';

	public function port() {
		return $this->belongsTo('App\Port');
	}

	public function budynek() {
		return $this->belongsTo('App\Budynek');
	}
}
