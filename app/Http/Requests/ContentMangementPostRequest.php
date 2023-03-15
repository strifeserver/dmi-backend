<?php

namespace App\Http\Requests;

use App\Services\AuthService;
use Illuminate\Foundation\Http\FormRequest;

class ContentMangementPostRequest extends FormRequest
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
        $this->merge([
            'onboard_content_image' => $this->file('onboard_content_image'),
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
            //
            'id' => [],
            'content_thumbnail' => [],
            'content_title' => ['nullable'],
            'content_url' => [],
            'content_schedule' => [],
            'content_start_time' => [],
            'content_end_time' => [],
            'content_location' => [],
            'content_time' => [],
            'content_images' => [],
            'onboard_content_image' => [],
            'sub_content_section' => ['nullable'],
            'content_description' => ['nullable'],
            'content_invitation' => ['nullable'],
            'content_footer' => ['nullable'],
            'content_category' => ['required','string'],
            'content_tags' => [],
            'content_status' => ['integer'],
            'is_live' => ['integer'],
            'onboard_content_files' => [],
            'content_files' => [],
            // 'created_by' => ['required', 'string', 'max:12'],
            // 'updated_by' => ['required', 'string', 'max:12'],
        ];
    }
}
