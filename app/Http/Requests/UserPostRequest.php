<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Services\AuthService;
use App\Rules\ComplexPassword;
use App\Services\SettingService;
class UserPostRequest extends FormRequest
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
    // public function prepareForValidation()
    // {
    //     $SettingPasswordComplex = app(SettingService::class)->getBySettingName('password_complex')->toArray()[0];

    //     $pc = $SettingPasswordComplex['setting_value'];
    //     $paasoword_complex = isset($pc) ? $pc : 'OFF';
    //     $pass_comp = ($paasoword_complex == 'ON') ? array('required', 'string', new ComplexPassword, 'confirmed')
    //         : array('required', 'string', 'confirmed');
     
    //     $this->merge([
    //         'password' => $pass_comp,
    //     ]);
    // }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $SettingPasswordComplex = app(SettingService::class)->getBySettingName('password_complex')->toArray()[0];
        $pc = $SettingPasswordComplex['setting_value'];
        $paasoword_complex = isset($pc) ? $pc : 'OFF';
        $pass_comp = ($paasoword_complex == 'ON') ? array('sometimes', 'string', new ComplexPassword, 'confirmed')
            : array('sometimes', 'string', 'confirmed');

        return [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'unique:core_users,username,' . @$this->input('id'),
            'email' => 'unique:core_users,email,' . @$this->input('id'),
            'password' => $pass_comp,
            'google2fa_secret' => 'string|nullable',
            'password_updated_at' => 'sometimes',
            'mobile_number' => 'string|nullable',
            'access_level' => 'required',
            'account_status' => 'required',
        ];
    }
}
