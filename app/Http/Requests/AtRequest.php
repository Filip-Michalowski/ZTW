<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jednostka;
use App\Port_Jednostki;
use App\Surowiec;
use App\Port_Surowce;
use Illuminate\Support\Facades\Redirect;
use Session;
use \Cache;
use App\Http\Requests\AtRequest;;

class AtRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
    foreach($this->request->get('name') as $key => $val)
	{
    $rules['name.'.$key] = 'integer';
    }
	return $rules;
	}

}
