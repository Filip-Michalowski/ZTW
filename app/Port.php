<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Port extends Model {

	protected $table = 'porty';
	
	protected $fillable = ['nazwa','gracz_id'];

	public function mapa() {
		return $this->belongsTo('App\Mapa');
	}
}
