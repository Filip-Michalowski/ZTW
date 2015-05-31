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
	    foreach($this->request->get('amount') as $key => $val)
		{
			echo $key;
	    	$rules['amount.'.$key] = 'integer';
	    }

	    if($this->request->get('colonization')) {
		    $rules['newport'] = 'required|unique:porty,nazwa';
		    $rules['major-general'] = 'required|integer|min:1|max:1';
		} else {
			//
		}

		return $rules;
	}

}
