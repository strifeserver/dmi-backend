<?php

namespace App\Imports;

use App\Curl_outbox;
use App\Telco_prefix;
use App\Sms_bar;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;
class OutboxImport implements ToModel, WithChunkReading, WithProgressBar, WithValidation, SkipsOnFailure
{
    use RemembersRowNumber, Importable, SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public $additional_data;
    public function __construct($additional_data = null)
    {
        $this->additional_data= $additional_data;
    }


    public function model(array $row)
    {
        
        $currentRowNumber = $this->getRowNumber();
        $rtest = $currentRowNumber-1;
        
        $job_data = $this->additional_data;
        $file = $job_data['file'];
        $filename = $job_data['filename'];
        $username = $job_data['username'];
        $tpl_mesg = $job_data['tpl_mesg'];
        $user_id = $job_data['user_id'];
        $group_id = $job_data['group_id'];
        $template_code = $job_data['template_code'];
        $time_and_date_send = $job_data['time_and_date_send'];
        $send_as = $job_data['send_as'];
        $total_rows = $job_data['total_rows'];
        $new_filename = $job_data['new_filename'];
        // $validated_filename = $job_data['validated_filename'];
        $done_path = public_path('tmp_files');
        $validated_filename = str_replace('.csv','',$job_data['filename']).'-'.$job_data['username'].'-validated-'.date('Y-m-d-H-i-A').'.csv';
        $validated_filename = $done_path.'/'.$new_filename;
       
        $str_find[$rtest] = "%".$rtest."%";
        $mobicol = 0;
        $mymobile = $row[$mobicol];
        $mymesg = str_replace($str_find,$row,$tpl_mesg);
       
        $mobilenum = $this->clean_mobile($mymobile);
        $telco = $this->getTelco(substr($mobilenum,0,5));
        $fullmesg = trim($mymesg);
        $is_bar = self::getBar($mobilenum);
        

        $csv_rows = self::makeArray($telco,$mobilenum,$tpl_mesg,$time_and_date_send,0,0,$user_id,$group_id,$send_as,$validated_filename,$template_code);
    
        $done_path = public_path('tmp_files');
        $myfile = fopen($validated_filename, "a") or die("Unable to open file!"); 
        $appendcsv = fputcsv($myfile, $csv_rows);
        fclose($myfile); 
  
    }
    public function rules(): array
    {
        return [
            // '1' => Rule::in(['patrick@maatwebsite.nl']),

            //  // Above is alias for as it always validates in batches
            //  '*.1' => Rule::in(['patrick@maatwebsite.nl']),
             
             // Can also use callback validation rules
             '0' => function($attribute, $value, $onFailure) {
   
                    // try {
                    //     //code...
                    //     $mobile_col = 0;
                    //     if($value){
                    //         $mobilenum = $this->clean_mobile($value);
    
                    //     }else{
                    //         // print_r($value);
                    //         // exit;
                    //     }

                    // } catch (\Throwable $th) {
                    //     //throw $th;
                    // }



                //   if ($value !== 'Patrick Brouwers') {
                //        $onFailure('Name is not Patrick Brouwers');
                //   }
              }
        ];
    }

    public function importer($source){
    // public function importer(){
        
        $importer = (new OutboxImport($this->additional_data))->import($source, null, \Maatwebsite\Excel\Excel::CSV);
      

        ## 17minutes = 1m
        ## batch size = 450000
        ## chunk size = 350000

    }
    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // echo '<pre>';
        // print_r($failures);
        // Handle the failures how you'd like.
    }


    public function batchSize(): int
    {
        return 350000;
    }
    
    public function chunkSize(): int
    {
        return 250000;
    }
    
    public function clean_mobile($mobile){
        $newmobilenum = preg_replace("/[^0-9]/",'',$mobile);
        $newmobilenum = ((strlen($newmobilenum)>=10) && ($newmobilenum != "") && (substr($newmobilenum,-10,1)=='9')) ? "63" . substr($newmobilenum,-10) : "";
        return $newmobilenum;
    }


    public function makeArray($telco,$mobilenum,$tpl_msg,$timeToSend,$sending_status,$msgbatch,$userid,$group_id,$send_as,$filename,$template_code){
        
        $csv_array = array();
        $csv_array[] = $telco; //telco
        $csv_array[] = $mobilenum; ///mobile num
        $csv_array[] = $tpl_msg; ////full msg
        $csv_array[] = $timeToSend;  //time to send
        $csv_array[] = $sending_status;  ///sending status
        $csv_array[] = $msgbatch;  //msgbatch
        $csv_array[] = $userid; //userid
        $csv_array[] = $group_id;  ///group id
        $csv_array[] = $send_as; ///originator
        $csv_array[] = $filename; //filename
        $csv_array[] = $template_code; //template code
        return $csv_array;
    }

    public function getTelco($pref){
        $res = Telco_prefix::select('telco_code')->where('Telco_prefix',$pref)->pluck('telco_code')->take(1)->toArray();
        return (count($res) > 0) ? $res[0] : '';
    }
    public function getBar($mobile){
        $bar = Sms_bar::select('id')->whereRaw('CONCAT("63", SUBSTRING(mobilenum, -10)) = '.$mobile)->count();
        return ($bar > 0) ? 1 : 0;
    }
}
