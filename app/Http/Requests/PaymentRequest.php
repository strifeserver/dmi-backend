<?php

namespace App\Http\Requests;

use App\Services\AuthService;
use App\Services\SanitizeService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected $authService;
    public function __construct(AuthService $authService, SanitizeService $sanitizeService)
    {
        $this->AuthService = $authService;
        $this->sanitizeService = $sanitizeService;

    }

    protected function prepareForValidation()
    {
        $this->merge([
            'payment_amount' => $this->sanitizeService->sanitizer($this->payment_amount),
            'description' => $this->sanitizeService->sanitizer($this->description),
            'remarks' => $this->sanitizeService->sanitizer($this->remarks),
        ]);
    }

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
            'payment_amount' => ['required', 'numeric', 'min:100.00'],
            'description' => ['nullable', 'string', 'max:400'],
            'remarks' => ['nullable', 'string', 'max:400'],
        ];
    }
    protected function failedValidation(Validator $validator) {
        $errs = $validator->errors()->toArray();
        $errs['status'] = 0;

        throw new HttpResponseException(response()->json($errs, 422));
    }


}
