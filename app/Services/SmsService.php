<?php

namespace App\Services;

class SmsService {


    /**
     * Constructs a new cart object.
     *
     */
    public function __construct()
    {

    }

    public function smsSend($data){

        // return true;

        // Set your API key and mobile number
        $apiKey = '006d0d31d2e4e47a5e35cf6623891d03';
        $mobileNumber = $data['mobile_number'];
        $message = $data['message'];
        
        // API URL
        $url = 'https://semaphore.co/api/v4/priority';
        
        // Data to send
        $data = array(
            'apikey' => $apiKey,
            'number' => $mobileNumber,
            'message' => $message
        );

        // Initialize cURL session
        $ch = curl_init($url);
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute cURL session and store the response
        $response = curl_exec($ch);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        }
        
        // Close cURL session
        curl_close($ch);
        
        // Display the response from the API
        echo $response;
        
        
        
    }

}