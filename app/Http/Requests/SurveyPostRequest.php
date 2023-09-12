<?php

namespace App\Http\Requests;

use App\Services\AuthService;
use Illuminate\Foundation\Http\FormRequest;

class SurveyPostRequest extends FormRequest
{

    protected $authService;
    public function __construct(AuthService $authService)
    {
        $this->AuthService = $authService;
    }
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $returns = false;
        // $method = $this->input('_method');
        $method = ($this->input('id')) ? 'PUT' : 'POST';

        $authorization = $this->AuthService->crud_guards($method);
        if ($authorization) {
            if (@$authorization['authorization']) {
                $returns = true;
            }
        }

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
            'id' => ['nullable'],
            'survey_id' => ['nullable'],
            'sqm_estimation' => ['nullable','integer'],
            'name' => ['required'],
            'email_address' => ['required','email'],
            'mobile_number' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Remove any non-numeric characters
                    $value = preg_replace('/[^0-9]/', '', $value);

                    // Check if the mobile number is either 11 digits starting with '639' or 10 digits starting with '09'
                    if (!preg_match('/^(639|09)\d{9}$/', $value)) {
                        $fail("The $attribute must be a valid mobile number in the format 639XXXXXXXXX or 09XXXXXXXXX.");
                        // echo 'FAIL';
                    }

                },
            ],
            'schedule_info' => ['nullable'],
            'status' => ['nullable'],
            'survey_pricing_details' => ['nullable'],
        ];
    }
}
