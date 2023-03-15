<?php

namespace App\Services;
use App\core_import_log;
class AuditService {

    protected $settings;
    protected $dataStatusService;
    
    public function __construct()
    {
    }

    public function file_auditing(){
        $returns = '';
        ## can display where file is edited/triggered
        $tracecallbacks = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        $filename = $tracecallbacks['file'];
        $function = $tracecallbacks['function'];
        $class = $tracecallbacks['class'];
        $returns = ['file'=>$filename,'function'=>$function,'class'=>$class];
        return $returns;
    }

    public function auditing($before_update,$after_update){
        #DATA HISTORY
        $returns = [];
        try {
            //code...
            $changes = array_diff($after_update,$before_update);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
        $returns = ['before_update'=>$before_update,'after_update'=>$after_update,'changes'=>@$changes];
        return $returns;
    }
    public function import_history($data){
        $importLog = core_import_log::create($data);
    }
    public function created_data($data,$executed){
        $returns = [];
        $returns = ['data_id'=>$executed->id,'created_data'=>$data, 'executed_raw'=>$executed];
        return $returns;
    }
    public function deleted_data($data,$executed){
        $returns = [];
        $returns = ['data_id'=>$executed->id,'created_data'=>$data, 'executed_raw'=>$executed];
        return $returns;
    }

    public function user_navigation_audit(){

    }
    


}