<?php namespace App\Http\Controllers;

use App;
use Session;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JezykController extends Controller {

	public function set_lang_en() {
		$cookie = Cookie::forever('lang','en');

		return Redirect::back()->withCookie($cookie);
	}

	public function set_lang_pl() {
		$cookie = Cookie::forever('lang','pl');

		return Redirect::back()->withCookie($cookie);
	}
}