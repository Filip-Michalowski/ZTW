<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Klan;
use Illuminate\Http\Request;

class KlanController extends Controller {

	public function index()
	{
		$klany = Klan::all();
		return view('klan.index', compact('klany'));
	}

	public function create()
	{
		return view('klan.create');
	}

}
