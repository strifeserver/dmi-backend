<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;


class CustomerPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $returns = true;
        return $returns;
    }

    public function prepareForValidation()
    {

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required','email'],
            'username' => ['required'],
            'password' => ['required'],
            'confirm_password' => ['nullable', 'same:password'], // Add 'same:password' rule
        ];
    }


    public function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $response = [
            'status' => 'error',
            'code' => 422,
            'message' => $errors,
            'result' => [],
        ];

        $response = response()->json($response, 422);

        throw new ValidationException($validator, $response);
    }
}
