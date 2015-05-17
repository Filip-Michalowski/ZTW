<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapa extends Model {

	protected $table = 'mapy';

	public function port() {
		//@if (isset($mapa->port->atrybut))
		return $this->hasOne('App\Port');
	}
}
