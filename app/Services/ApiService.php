<?php

namespace App\Services;

class ApiService
{
    public function api_returns(array $data): array
    {
        $result = array();
        
        if(!empty($data['data_id'])){
            $result['id'] = $data['data_id'];
        }
        $exec_res = ($data['status'] == 1);
        if(!empty($data['result'])){
            $result['remarks'] = $data['result'];
        }
        if(!empty($data['data'])){
            $result = $data['data'];
        }
        if(!empty($data['message'])){
            $message = $data['message'];
        }else{
            $message = [];
        }
        $response = array();
        $response['status'] = $exec_res ? "success" : "error";
        $response['code'] = $exec_res ? 200 : 400;
        $response['message'] = $exec_res ? $message : array('Bad Request');
        $response['result'] = $result;
        return $response;
    }

}
