<?php namespace App\Http\Controllers;

use App\Gracz_Porty;
use App\User;
use App\Port;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Cache;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{		
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//session_start();
		$id = Auth::user()->id;
		$gracz_porty = Port::where('gracz_id','=',$id)
		->get();

		/*vvv*///Dodałem tę linię, bo w mapie muszę użyć tego klucza
		Cache::forever('id_akt',$gracz_porty->first()->id);
		/*^^^*/

		//$_SESSION['porty'] = $gracz_porty;
		return view('przeglad.index',compact ('gracz_porty'));
	}

	public function get_id_port($id)
	{
		//Czy na pewno to powinno być cache?
		Cache::forever('id_akt',$id);
		//return Redirect::action('HomeController@index');
		return Redirect::action('HomeController@index');//działa
	}

	public function actual_logout() {//nie działa
		Session::flush();
		return Redirect::to('/auth/logout');
	}
}
