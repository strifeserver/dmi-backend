<?php

namespace App\Http\Requests;

use App\Services\AuthService;
use App\Services\SanitizeService;
use Illuminate\Foundation\Http\FormRequest;

class EmailPostRequest extends FormRequest
{

    protected $authService;
    public function __construct(AuthService $authService, SanitizeService $sanitizeService)
    {
        $this->AuthService = $authService;
        $this->sanitizeService = $sanitizeService;

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $returns = false;
        $method = $this->input('_method');
        if(empty($method)){
            $method = 'STORE';
        }
        $authorization = $this->AuthService->crud_guards($method);
        if ($authorization) {
            if ($authorization['authorization']) {
                $returns = true;
            }
        }
        return $returns;

    }
    protected function prepareForValidation()
    {
        $this->merge([
            'email_header' => $this->sanitizeService->sanitizer($this->email_header),
            // 'email_body' => $this->sanitizeService->sanitizer($this->email_body),
            'status' => $this->sanitizeService->sanitizer($this->status),
        ]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email_header'=> 'required|string',
            'email_body'=> 'required|string',
            'status'=> 'required|numeric',
        ];
    }
}
