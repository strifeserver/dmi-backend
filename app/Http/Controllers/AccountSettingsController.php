<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\ComplexPassword;
use App\User;
use App\CoreUserLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Validator;

class AccountSettingsController extends Controller
{
    public function __construct(User $User, CoreUserLevel $CoreUserLevel)
    {
        $this->db_table = $User;
        $this->GenSet = $this->getGeneralSettings();
        $this->CoreUserLevel = $CoreUserLevel;
    }
    public function validator(Request $request)
    {
        $id = $this->sanitizer($request->input('id'));
        $mode = $this->sanitizer($request->input('mode'));
        $pc = $this->GenSet['Password_Complex'];
        $paasoword_complex = isset($pc) ? $pc : 'OFF';
        $pass_comp = ($paasoword_complex == 'ON') ? array('required', 'string', new ComplexPassword, 'confirmed')
            : array('required', 'string', 'confirmed');

        $input = [
            'username' => $this->sanitizer($request->input('username')),
            'password' => $this->sanitizer($request->input('password')),
            'password_confirmation' => $this->sanitizer($request->input('password_confirmation')),
            'first_name' => $this->sanitizer($request->input('first_name')),
            'last_name' => $this->sanitizer($request->input('last_name')),
            'email' => $this->sanitizer($request->input('email')),
            'mobile_number' => $this->sanitizer($request->input('mobile_number')),
            'access_level' => $this->sanitizer($request->input('access_level')),
            'password_updated_at' => Carbon::now(),
        ];

        $rules = [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'username' => 'unique:core_users,username,' . $id,
            'email' => 'unique:core_users,email,' . $id,
            'password' => $pass_comp,
            'google2fa_secret' => 'string',
            'password_updated_at' => 'required',
            'mobile_number' => 'string|nullable',
            'access_level' => 'required',
        ];

        $messages = [];

        $customAttributes = [];
        if ($mode == 'account_settings') {
            unset($input['password']);
            unset($input['password_confirmation']);
            unset($input['access_level']);

            unset($rules['password']);
            unset($rules['password_confirmation']);
            unset($rules['password_updated_at']);
            unset($rules['google2fa_secret']);
            unset($rules['access_level']);
        }

        if ($mode == 'change_pass') {
            unset($rules['first_name']);
            unset($rules['last_name']);
            unset($rules['last_name']);
            unset($rules['access_level']);
            unset($rules['username']);
            unset($rules['email']);
            unset($rules['mobile_number']);
            
            $input['password'] = $request->new_password;
            $input['password_confirmation'] = $request->new_password_confirmation;
          
        }
        
        $validator = Validator::make($input, $rules, $messages, $customAttributes);
        if ($mode == 'change_pass') {
            $returns = [];
            $remarks = [];
            $user = User::findOrFail($id);
            $check_password = Hash::check($request->current_password, $user->password);

            if (!$check_password) {
                $remarks[] = 'Old password does not match';
                $returns = ['status' => 'failed', 'remarks' => $remarks];
            }
            if ($this->sanitizer($request->new_password) != $this->sanitizer($request->new_password_confirmation)) {
                $remarks[] = 'New password does not match';
                $returns = ['status' => 'failed', 'remarks' => $remarks];
            }
            $returns['remarks'] = implode('<br>', $returns['remarks']);

            if (@$returns['status'] == 'failed') {
                return $returns;
            }
        }

        return $validator->validate();
    }
    public function index(Request $request)
    {
    	$accesslevel = json_decode($this->acclvl());

    	$id = $this->sanitizer($request->input('id'));
    	$validator = $this->validator($request);

    	if ($validator) {
    	    $data = $this->db_table->findOrFail($id);

    	    if ($data) {
    	        if (@$validator['status'] != 'failed') {

    	            $before_update = $data->toArray();
    	            $after_update = $validator;
    	            $changes = array_diff($after_update, $before_update);
    	            $changes_auditing = ['before_update' => $before_update, 'after_update' => $after_update, 'changes' => $changes];
    	            $core_audit_trail = $this->audit_trail('', 'UPDATE', $changes_auditing, $id);
    	            $update = $data->update($validator);
    	        }
    	    }

    	    if ($request->input('mode') == 'account_settings' || $request->input('mode') == 'change_pass') {
    	        $msg = 'Users Updated Successfully';
    	        if (@$validator['status'] == 'failed') {
    	            $error =  $validator['remarks'];
    	            $msg = '';
    	        }

    	        return redirect()->back()
    	            ->with('success', $msg)
    	            ->with('mode', $request->input('mode'))
    	            ->with('failed', @$error);
    	    } 
    	} else {
    	    $audit = $this->audit('', '', 'UNAUTHORIZED', $request->input('id'));
    	    return abort(404);
    	}
    }
}
