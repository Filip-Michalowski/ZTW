<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Jednostka_Koszty extends Model {

	protected $table = 'jednostka_koszty';

	public function jednostka() {
		return $this->belongsTo('App\Jednostka');
	}
}
