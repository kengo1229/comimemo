<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MakeMemoRequest extends FormRequest
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
        return [
          'secondaryName' => 'required|max:20',
        ];
    }

    public function messages()
    {
        return [
            'secondaryName.required' => '入力必須です',
            'secondaryName.max' => '20文字以内で入力してください',
        ];
    }

    protected function failedValidation(Validator $validator)
   {
       $errors = collect($validator->errors());
       $messages = $errors->map(function($error_messages){
           return $error_messages[0];

       });

       throw new HttpResponseException(response(
           $messages,
           422
       ));
   }

}
