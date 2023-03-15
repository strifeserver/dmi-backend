<?php

namespace App\Services;

use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use File;
class ExportService
{

    /**
     *
     */
    protected $db;
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
        $importMode = $data['import_mode'];
        $importModule = $data['import_module'];
        $fileName = $importMode.'_'.$importModule.'_'.date('mdY').'.csv';


        $store = Excel::store(new ProductsExport($data), $fileName, 'exports', \Maatwebsite\Excel\Excel::CSV);
        if($store){
            $returns['status'] = 'success';
            $returns['details'] = ['remarks'=>'Export file created','url'=>'export_files/'.$fileName];
        }else{
            $returns['status'] = 'failed';
        }
        return $returns;
    }

}
