<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mapa;
use Illuminate\Http\Request;

class MapaController extends Controller {

	public function index()
	{
		$mapy = Mapa::all();

		$mapy_alt = Mapa::where('pos_x', '>', 0)
			->where('pos_x', '<', 6)
			->where('pos_y', '>', 0)
			->where('pos_y', '<', 6)
			->get();

		return view('mapa.index',compact('mapy','mapy_alt'));
	}
}
