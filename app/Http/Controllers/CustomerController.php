<?php

namespace App\Http\Controllers;

use App\Services\BearerTokenService;
use App\Services\CustomerService;
use App\Services\MailService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class CustomerController extends Controller
{

    public function __construct(CustomerService $CustomerService, BearerTokenService $tokenService)
    {
        $this->CustomerService = $CustomerService;
        $this->tokenService = $tokenService;
    }

    public function validator($request)
    {
        $returns = 0; # 1 VALID
        $input = [
            'first_name' => @$request['first_name'],
            'last_name' => @$request['last_name'],
            'email' => @$request['email'],
            // 'username' => @$request['username'],
            'password' => @$request['password'],
            'password_confirmation' => @$request['password_confirmation'],

        ];
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:core_users,email',
            // 'username' => 'required|unique:core_users,username',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ];
        $messages = [];
        $customAttributes = [
        ];

        $validator = Validator::make($input, $rules, $messages, $customAttributes);
        $errs = $validator->errors()->toArray();

        if (empty($errs)) {
            $returns = 1;
        } else {
            $returns = $errs;
        }

        return $returns;
    }

    public function register(request $request)
    {

        $EmailService = app(MailService::class);
        $token = $this->tokenService->generate('activate_account')['result'];
        $hash = Hash::make($request->email);
        $baseUrl = url('/');



        $validator = $this->validator($request);

        if ($validator == 1) {
            $reStructure = [
                'hash' => $hash,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->email,
                'email' => $request->email,
                'password' => $request->password,
                'access_level' => 3,
                'account_status' => 3,
            ];
       
            $store = $this->CustomerService->store($reStructure);

            $replaceables = [];
            $replaceables[] = $baseUrl . '/activate?token=' . $token . '&hash=' . $hash;
            $execution = $EmailService->send($request->email, '', '', '', 'activate-account-template', '', $replaceables);


            if ($store['status'] == 'success') {
                return redirect()->route('login')->with('success', 'Registration successful! Please check your email address for Account Activation');
            }
        } else {
            return redirect()->back()->withErrors($validator);
        }

    }

    public function activateAccount()
    {

        $hash = $_GET['hash'];

        $findUser = User::where('hash', '=', $hash)->first();
        if ($findUser) {
            // Update the user's account_status to 1
            $findUser->account_status = 1;
            $findUser->save();

            // Set the success message
            $successMessage = 'Account successfully created';

            // Redirect to the login page with the success message
            return redirect()->route('login')->with('success', 'Account Activated');

        } else {
            return redirect()->route('login')->with('error', 'Account not found');
        }

    }

}
