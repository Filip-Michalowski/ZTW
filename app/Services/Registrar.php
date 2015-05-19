<?php namespace App\Services;

use App\User;
use Validator;
use App\Port;
use App\Http\Controllers\PortController;
use Request;
use Route;
use Input;
use App\Mapa;
use \DB;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		Validator::extend('wolne_miejsce', function($attribute, $value, $parameters)
		{
			$mapy = Mapa::where('typ','>','0')->where('port_id','=',null)->count();
			return ($mapy > 0);
		});

		$validator = Validator::make($data, [
			'name' => 'required|max:255|unique:users',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'nazwa' => 'required|max:60|unique:porty',
			'nazwa' => 'wolne_miejsce'
		], [
			'wolne_miejsce' => 'Wszystkie wyspy są zajęte.'
		]);

		return $validator;
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{			
		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password'])
		]);

		Port::createRand($data['nazwa'], $user->id);


		return $user;
	}

}
