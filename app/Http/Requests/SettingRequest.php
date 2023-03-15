<?php

namespace App\Http\Requests;

use App\Services\AuthService;
use App\Services\SanitizeService;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'setting_name' => $this->sanitizeService->sanitizer($this->setting_name),
            'setting_value' => $this->sanitizeService->sanitizer($this->setting_value),
            'setting_description' => $this->sanitizeService->sanitizer($this->setting_description),
            'file_path' => $this->sanitizeService->sanitizer($this->file_path),
            'category' => $this->sanitizeService->sanitizer($this->category),
            'img' => $this->img,
        ]);
    }

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $id = $this->id ?? null;
        $unique_rule = 'unique:core_settings,setting_name,' . $id;
        return [
            //
            'setting_name' => ['required', 'max:50', $unique_rule],
            'setting_value' => ['required', 'string', 'max:100'],
            'setting_description' => ['required', 'string'],
            'file_path' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'img' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
}
