<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;
class DataStatusService {

    const STATUS = [0=>'failed',1=>'success'];
    const STATUS_MESSAGES = [
        'Failed to',
        'Successfully '
    ];
    /**
     * Constructs a new cart object.
     *
     */
    public function __construct()
    {

    }

    public function data_status($result){
        $returns = [];
        $return['status'] = self::STATUS[$result];
        $return['message'] = self::STATUS_MESSAGES[$result];
        return $return;
    }

}