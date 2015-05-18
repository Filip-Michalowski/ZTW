<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Port extends Model {

	protected $table = 'porty';
	
	protected $fillable = ['nazwa','gracz_id'];
<<<<<<< HEAD
=======

	public function mapa() {
		return $this->hasOne('App\Mapa');
	}
>>>>>>> origin/mapy_eksperymentalna
}
