<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddMemoItemRequest extends FormRequest
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
              'secondaryTitle' => 'required|max:30',
              'secondaryNumber' => 'required|integer|max:300|min:1',
          ];
    }

    public function messages()
    {
          return [
              'secondaryTitle.required' => ':attributeは入力必須です',
              'secondaryTitle.max' => ':attributeは30文字以内で入力してください',
              'secondaryNumber.required' => ':attributeは入力必須です',
              'secondaryNumber.integer' => ':attributeは整数値で入力してください',
              'secondaryNumber.min' => ':attributeは1巻以上で入力してください',
              'secondaryNumber.max' => ':attributeは300巻以下で入力してください',
          ];
    }

    public function attributes()
    {
        return [
            'secondaryTitle' => 'タイトル',
            'secondaryNumber' => '巻数',
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
