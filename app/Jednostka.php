<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Jednostka extends Model {

	protected $table = 'jednostki';

	public function koszty() {
		return $this->hasMany('App\Jednostka_Koszty');
	}
}
