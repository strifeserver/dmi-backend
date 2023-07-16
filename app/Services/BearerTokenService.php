<?php

namespace App\Services;

use Helper;
/**
 * Intro: https://jwt.io/introduction
 * Specs: https://datatracker.ietf.org/doc/html/rfc7519#section-3.1
 * Sample: https://dev.to/robdwaller/how-to-create-a-json-web-token-using-php-3gml
 */
class BearerTokenService
{
    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    const VALID_FOR = 5 * 60; // Seconds

    /**
     * Generate JWT
     *
     * @param $subject string Any user identifier
     */
    public function generate($subject)
    {
        $timestamp = time();
        $header = self::b64URL(['alg' => 'HS256', 'type' => 'JWT']);
        $claims = self::b64URL([
            'iss' => 'System',
            'sub' => $subject,
            'iat' => $timestamp,
            'exp' => $timestamp + self::VALID_FOR,
        ]);
        $signature = self::b64URL(hash_hmac(
            'sha256',
            "{$header}.{$claims}",
            config('app.key'),
            true
        ));

        // return "{$header}.{$claims}.{$signature}";
        $returns['status'] = 1;
        $returns['data'] = "{$header}.{$claims}.{$signature}";
        $response = $this->helper->apiResponse($returns['status'], 200, [], $returns['data']);
        return $response;
    }

    /**
     * Validate JWT in Authorization header
     */
    public function validate($request)
    {

        $bearer_token = $request['token'];
        [$header, $claims, $signature] = self::parse($bearer_token);
        $s0 = self::b64URL(hash_hmac('sha256', "{$header}.{$claims}", config('app.key'), true));

        // Invalid signature?
        if ($signature !== $s0) {
            return [false, self::unauthorized()];
        }

        // Has expired?
        $c0 = json_decode(base64_decode($claims), true);
        if (time() > $c0['exp']) {
            return [false, self::expired($c0['iat'], $c0['exp'])];
        }

        $check_token = $this->check_token($request);
        if ($check_token) {
            return [true, ['status' => 'success', 'description' => 'authorized', 'token_status' => $check_token['remarks']]];
        }

        return [true, ['status' => 'success', 'description' => 'authorized']];
    }

    public function check_token($params)
    {

        $returns = ['status' => 1];
        $token = $params['token'];
        $category = $params['category'] ?? '';
        if (empty($category)) {
            $category = $params['mode'] ?? '';
        }
        // $check_db_token = Token::where('token', $token)->first();
        // if (!$check_db_token) {
        //     // record token
        //     $insert = new token();
        //     $insert->token = $token;
        //     $insert->category = $category;
        //     $saving = $insert->save();
        //     $returns['remarks'] = 'saved';
        // } else {
        //     $returns['remarks'] = 'used';
        // }
        return $returns;
    }

    /**
     * Get claims section of the JWT (value of Authorization header)
     *
     * **WARNING**: You MUST call validate() first before trusting any
     *  of the contents of the claims header
     */
    public static function claims($request)
    {
        $bearer_token = $request['token'];
        [, $claims] = self::parse($bearer_token);
        return json_decode(base64_decode($claims), true);
    }

    private static function parse($jwt)
    {
        return collect(explode('.', $jwt))
            ->pad(3, '')
            ->toArray();
    }

    private static function unauthorized()
    {
        return ['status' => 'failed', 'description' => 'invalid_token'];
    }

    private static function expired($iat, $exp)
    {
        return [
            'status' => 'failed',
            'description' => 'expired_token',
            'remarks' => 'The token has already expired.',
        ];
    }

    private static function b64URL($data)
    {
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode(
                is_array($data) ? json_encode($data) : $data)
        );
    }
}
