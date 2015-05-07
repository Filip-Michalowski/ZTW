<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mapa;
use Illuminate\Http\Request;

class MapaController extends Controller {

	public function index()
	{
		$mapy = Mapa::all();
		return view('mapa.index',compact('mapy'));
	}

	

}
