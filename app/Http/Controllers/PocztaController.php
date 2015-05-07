<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Poczta;
use Illuminate\Http\Request;

class PocztaController extends Controller {

	
	public function index()
	{
		$poczty = Poczta::all();
		return view('poczta.index',compact('poczty'));
	}

	public function create()
	{
		return view('poczta.create');
	}

}
