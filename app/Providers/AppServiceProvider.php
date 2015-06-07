<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Session;
use Cookie;
use Config;
use Crypt;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$cookie_encrypt = Cookie::get('lang');
		if($cookie_encrypt != null) {
			$cookie_string = Crypt::decrypt(Cookie::get('lang'));
			App::setLocale($cookie_string);
		}
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
