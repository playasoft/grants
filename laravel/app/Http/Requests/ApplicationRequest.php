<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ApplicationRequest extends Request
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
        $moneyFormat = 'regex:/^\$?[0-9.,]+$/';

        return
        [
            'name' => "required|min:3",
            'description' => "required|min:100",
            'budget' => "required|" . $moneyFormat,
        ];
    }
}
