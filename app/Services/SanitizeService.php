<?php

namespace App\Services;

class SanitizeService {


    /**
     * Constructs a new cart object.
     *
     */
    public function __construct()
    {

    }

    public function sanitizer($input){
        // $return = Purifier::clean(strip_tags(htmlspecialchars($input)));
          $return = \Purifier::clean($input,['HTML.Allowed' => '']);
        return $return;
      }

}