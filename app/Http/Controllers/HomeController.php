<?php namespace App\Http\Controllers;
use App\Gracz_Porty;
use App\User;
use App\Port;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use \Cache;
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
		$gracz_porty = Gracz_Porty::leftjoin('porty',function($join){
			$join->on('gracz_porty.port_id','=','porty.id');})->where('gracz_id','=',$id)
		->get();
		//$_SESSION['porty'] = $gracz_porty;
		return view('przeglad.index',compact ('gracz_porty'));
	}

	public function get_id_port($id)
	{
		//Cache::forever('id_akt',$id);

		Cookie::make('id_akt',$id);
	// $id = Auth::user()->id;
	// 	$gracz_porty = Gracz_Porty::leftjoin('porty',function($join){
	// 		$join->on('gracz_porty.port_id','=','porty.id');})->where('gracz_id','=',$id)
	// 	->get();
	// 	//$_SESSION['porty'] = $gracz_porty;
	// 	//return view('przeglad.index',compact ('gracz_porty'));
		return Redirect::action('HomeController@index');
	}

}
