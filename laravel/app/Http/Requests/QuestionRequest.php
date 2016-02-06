<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class QuestionRequest extends Request
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
            'question' => 'required|min:3',
            'type' => 'required|in:input,text,dropdown,boolean,file',
            'status' => 'required|in:new,submitted,review,follow-up,accepted,rejected',
            'role' => 'required|in:applicant,judge'
        ];
    }
}
