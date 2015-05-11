<?php namespace App\Services;

use App\User;
use Validator;
use App\Port;
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
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{


		/*return User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);
*/

			
			$user= User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		]);

		$port =DB::table('porty')->insert(
				['nazwa'=>'nowa']
			);

			$porty = Port::all();
			
		/*DB::table('gracz_porty')->insert()
			['gracz_id' => $user->id,
			'port_id' => $port->id])
		;*/
			return $user;
	}

}
