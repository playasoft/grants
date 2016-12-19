<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Misc\Helper;

class RoundRequest extends Request
{
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
        return
        [
            'name' => 'required',
            'description' => 'required|min:50',
            'budget' => Helper::$moneyFormat,
            'min_request_amount' => Helper::$moneyFormat,
            'max_request_amount' => Helper::$moneyFormat,
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d'
        ];
    }
}
