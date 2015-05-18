<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Mapa extends Model {

	protected $table = 'mapy';

	public function port() {
		return $this->belongsTo('App\Port');
	}
}
