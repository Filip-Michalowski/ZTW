<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Surowiec;
use App\Port;
use App\Port_Surowce;
use App\Budynek_Surowce;
use Session;
use Illuminate\Http\Request;

class SurowiecController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Stare:
		/*$surowce = Surowiec::all();
		return view('surowiec.index',compact('surowce'));*/

		$port_id = Session::get('id_akt');

		$surowce = Surowiec::all();
		
		$port_surowce = Surowiec::join('port_surowce','surowce.id','=', 'port_surowce.surowiec_id', 'left outer')
			->where('port_surowce.port_id','=', $port_id)
			->orWhere('port_surowce.port_id','=', null)
			->orderBy('id')
			->get();

		return view('surowiec.index',compact('surowce','port_surowce','port_id'));		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $port_id
	 * @return Response
	 */
	public function update($port_id)
	{
		//gdzie $id to id portu

		$ps = Port_Surowce::where()
			->get();

		foreach ($variable as $key) {
			# code...
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
