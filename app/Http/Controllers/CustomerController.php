<?php

namespace App\Http\Controllers;

use App\Services\BearerTokenService;
use App\Services\CustomerService;
use App\Services\MailService;
use App\Services\SmsService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

// use Illuminate\Validation\Rule;
// use Illuminate\Validation\ValidationRule;
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
            'mobile_number' => @$request['mobile_number'],
            // 'username' => @$request['username'],
            'password' => @$request['password'],
            'password_confirmation' => @$request['password_confirmation'],

        ];
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:core_users,email',
            'mobile_number' => [
                'nullable',
                'unique:core_users,mobile_number',
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

        $mobileNumber = '';

        if (!empty($request->mobile_number)) {
            if (strlen($request->mobile_number) === 11 && substr($request->mobile_number, 0, 2) === '09') {
                $mobileNumber = '639' . substr($request->mobile_number, 2);
            } else {
                $mobileNumber = $request->mobile_number;
            }

        }

        if ($validator == 1) {
            $reStructure = [
                'hash' => $hash,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->email,
                'email' => $request->email,
                'password' => $request->password,
                'mobile_number' => $mobileNumber,
                'access_level' => 3,
                'account_status' => 3,
            ];

            $store = $this->CustomerService->store($reStructure);

            $replaceables = [];
            $replaceables[] = $baseUrl . '/activate?token=' . $token . '&hash=' . $hash;
            $execution = $EmailService->send($request->email, '', '', '', 'activate-account-template', '', $replaceables);

            if(!empty($mobileNumber)){

                $SmsService = app(SmsService::class);
                $smsSendData = [
                    'mobile_number'=> $mobileNumber,
                    'message'=> 'Welcome to DMI please check your email for your Account Activation',
                ];
                $smsNotification = $SmsService->smsSend($smsSendData);
            }



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
