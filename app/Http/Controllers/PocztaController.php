<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Poczta;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\User;

class PocztaController extends Controller {

	
	public function index()
	{
		$poczty = Poczta::all();
		$id = Auth::user()->id;
		return view('poczta.index', compact('poczty', 'id'));
	}

	public function create()
	{
		$id = Auth::user()->id;
		return view('poczta.create', compact('id'));
	}

	public function store(Request $request)
	{
		$temat = $request->input('temat');
		$nadawca = $request->input('nadawca');
		$nadawca1 = User::where('id', $nadawca)->first();
		$nadawca2 = $nadawca1->name;
		$odbiorca = $request->input('odbiorca');
		$odbiorca1 = User::where('name', $odbiorca)->first();
		$odbiorca2 = $odbiorca1->id;
		$data = date("Y-m-d H:i:s");
		$tekst = $request->input('tekst');

		Poczta::insert(['temat' => $temat, 'nadawca' => $nadawca2, 'odbiorca_id' => $odbiorca2, 'tekst' => $tekst, 'data' => $data]);

		return Redirect::action('PocztaController@index');
	}

	public function read($id)
	{
		$poczta = Poczta::findOrFail($id);
		return view('poczta.read',compact('poczta'));

	}

	public function delete($id)
	{
	 	Poczta::where('id', $id)->delete();
	 	return Redirect::action('PocztaController@index');
	}

}
