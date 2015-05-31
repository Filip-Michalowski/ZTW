<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Atak_Jednostki extends Model {

	protected $table = 'atak_jednostki';
	
	protected $fillable = ['atak_id',
			'jednostka_id',
			'ilosc_wyjscie'];

	public function atak() {
		return $this->belongsTo('App\Atak');
	}

	public function jednostka() {
		return $this->belongsTo('App\Jednostka');
	}
}
