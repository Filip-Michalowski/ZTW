<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mapa;
use Auth;
use Illuminate\Http\Request;

class MapaController extends Controller {

	public function index()
	{
		//$mapy = Mapa::all();

		$lower_bond = 2;
		$upper_bond = $lower_bond + 6;

		$mapy = Mapa::where('pos_x', '>=', $lower_bond)
			->where('pos_x', '<=', $upper_bond)
			->where('pos_y', '>=', $lower_bond)
			->where('pos_y', '<=', $upper_bond)
			->orderBy('pos_y','asc')
			->orderBy('pos_x','asc')
			->with('port')
			->get();

		$gracz = Auth::user()->id;

		return view('mapa.index',compact('mapy','lower_bond','upper_bond','gracz'));
	}
}
