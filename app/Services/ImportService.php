<?php

namespace App\Services;

use Maatwebsite\Excel\Facades\Excel;



class ImportService
{

    /**
     *
     */
    protected $db;
    protected $productService;
    public function __construct()
    {
    }

    public function update($request)
    {

    }
    public function create($data)
    {
        $returns = [];
        $data = $data->all();
        $import_mode = request('import_mode');
        $import_file = request('import_file');
        $import_file = storage_path('test.csv');
        switch ($import_mode) {
            case '':
    
            default:
                break;
        }
        return $returns;
    }

}
