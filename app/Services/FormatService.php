<?php

namespace App\Services;

use Illuminate\Support\Facades\Gate;
class FormatService {


    /**
     * Constructs a new cart object.
     *
     */
    public function __construct()
    {

    }
    public function filter_date_format_v2($requestFrom, $requestTo)
    {
        $datefrom1 = explode('-', $requestFrom);
        $dateto1 = explode('-', $requestTo);
        $from1 = $datefrom1[0] . '-' . $datefrom1[1] . '-' . $datefrom1[2] . ' 00:00:00';
        $to = $dateto1[0] . '-' . $dateto1[1] . '-' . $dateto1[2] . ' 23:59:59';

        $return = ['from' => $from1, 'to' => $to];
        return $return;
    }



}