<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Services\ApiService;
use App\Services\BearerTokenService;
use App\Services\MailService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class AccountService
{

    public function __construct(BearerTokenService $tokenService, ApiService $api_service, AccountRepository $repository)
    {
        $this->tokenService = $tokenService;
        $this->api_service = $api_service;
        $this->repository = $repository;
    }

    public function validator($request)
    {
        $returns = 0;
        $mode = $request['mode'];
        switch ($mode) {
            case 'reset_password':
                $input = [
                    'token' => @$request['token'],
                    'hash' => @$request['hash'],
                    'new_password' => @$request['new_password'],
                ];
                $rules = [
                    'token' => 'required|string',
                    'hash' => 'required|string',
                    'new_password' => 'required|string',
                ];
                $messages = [];
                $customAttributes = [
                    'token' => 'Token',
                    'hash' => 'Hash',
                    'new_password' => 'New Password',
        
                ];
            break;
            case 'email_forgot_password':
                $input = [
                    'email' => @$request['email'],
                ];
                $rules = [
                    'email' => 'required|string|exists:admin_users,email_address',
                ];
                $messages = [];
                $customAttributes = [
                    'email' => 'Email',
                ];
            break;
        }

        $validator = Validator::make($input, $rules, $messages, $customAttributes);
        $errs = $validator->errors()->toArray();

        if (empty($errs)) {
            $returns = 1;
        } else {
            $returns = $errs;
        }

        return $returns;
    }

    public function build_password($password)
    {
        $id = bin2hex(random_bytes(12));
        $hash = $id . $password;
        $built_password = password_hash($hash, PASSWORD_DEFAULT) . ":" . $id;
        return $built_password;
    }

    /**
     * @return array
     * @param array $request
     */
    public function reset_password(array $request): array
    {
        $returns = ['status' => 0];
        $request['mode'] = 'reset_password';
        $validator = $this->validator($request);
        if ($validator == 1) {
            $token = $request['token'] ?? null;
            $hash = $request['hash'] ?? null;
            $new_password = $request['new_password'] ?? null;

            #verify token
            $verify_token = $this->tokenService->validate($request);
            if ($verify_token[1]['status'] == 'success') {
                $claim_token = $this->tokenService->claims($request);
                # verify token claim
                if ($claim_token['sub'] == 'forgot-password-change') {
                    if($verify_token[1]['token_status'] != 'used'){
                        $buit_password = $this->build_password($new_password);
                        $data = ['id' => $hash, 'password' => $buit_password];
                        $execution = $this->repository->update($data);
                        $returns = $execution;
                    }else{
                        $returns['result'] = ['Token'=>'Invalid Token'];
                    }
                } else {
                    $returns['result'] = ['Token'=>'Invalid Token'];
                }
            } else {
                $token_remarks = $verify_token[1]['remarks'] ?? $verify_token[1]['description'];
                
                $returns['result'] = ['Token'=>$token_remarks];
            }
        } else {
            $returns['result'] = $validator;
        }

        $response = $this->api_service->api_returns($returns);
        return $response;
    }

    public function email_forgot_password($request)
    {
        $environment = Config::get('config.environment');
        
        $returns = ['status' => 0];
        $email = $request['email'] ?? null;
        $request['mode'] = 'email_forgot_password';
        $validator = $this->validator($request);
        $admin_url = Config::get('config.admin_url');
       
        if ($validator == 1) {
            $execution = $this->repository->edit($email);
            if ($execution) {
                $EmailService = app(MailService::class);
                $token = $this->tokenService->generate('forgot-password-change')['result'];
                $hash = $execution['data']['hash'];
                $to = $execution['data']['email_address'];
                $baseUrl = url('');
                
                $replaceables = [];
                $replaceables[1] = $admin_url.'/forgot/reset?token=' . $token . '&hash=' . $hash;
                $execution = $EmailService->send($to, '', '', '', 'forgot-password-template', '', $replaceables);
                unset($execution['result']['remarks']);
          
                if ($execution['status'] == 'success') {
                    $execution['status'] = 1;
                }
                $returns = $execution;
            }
        }else{
            $returns['result'] = $validator;
        }
        
        $response = $this->api_service->api_returns($returns);
        return $response;
    }
    public function edit($Id): array
    {
        $execution = $this->repository->edit($Id);
     
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

}
