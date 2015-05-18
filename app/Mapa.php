<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapa extends Model {

	protected $table = 'mapy';

<<<<<<< HEAD
=======
	public function port() {
		//@if (isset($mapa->port->atrybut))
		return $this->belongsTo('App\Port');
	}
>>>>>>> origin/mapy_eksperymentalna
}
