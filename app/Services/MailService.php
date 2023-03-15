<?php

namespace App\Services;

// use Illuminate\Support\Facades\Config;
// use Mail;
// use App\Emails\SendMail;
// use AppCoreEmailTemplate;
// use App\Jobs\JobMailer;
use Illuminate\Support\Facades\Config;
use Swift_TransportException;
use Swift_RfcComplianceException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use Carbon\Carbon;
use DB;


class MailService
{

    public function configuration(){
        $returns = [];
        $returns['from_name'] = env('MAIL_FROM_NAME');
        $returns['from'] = env('MAIL_FROM_ADDRESS');
        return $returns;
    }


    /**
     * @return array
     * @param [can be array(multiple) or string(single)] $from
     * @param [string] $to
     * @param [string] $subject
     * @param [string] $messageBody
     */

    public function payloading(array $data){

        // Initialization
        $to = @$data['to'];
        $subject = @$data['subject'];
        $messageBody = @$data['content'];


        $returns = [];
        $audit = [];
        $validator = true;
        $simulator = request('simulator') ?? false; ## true - to avoid actual sending but still logs;
        // Initialization
        
        //validators
        if(!empty($to)){
            $validator = false;
            $returns['remarks'][] = 'Receiver is empty';
        }
        //validators

        // Outbox Logging
            $audit['receiver'] = json_encode($data['to']);
            $audit['subject'] = $data['subject'];
            $audit['content'] = $data['content'];
        // Outbox Logging
       $template = [
        'to'=> $data['to'],
        'subject'=> $data['subject'],
        'messageBody'=>$data['content']
       ];



        if(!$simulator){
            try {
                $execution = $this->execution($template);
                
            } catch (\Throwable $th) {
                //throw $th;
                $th = $th->getMessage();
                $audit['remarks'] = json_encode($th);
            }
            $audit['status'] = @$execution['status'];
            
        }else{
            $audit['status'] = 'success';
        }
        // Outbox execution
        try {
            $audit['created_at'] = Carbon::now()->toDateTimeString();
            $audit['updated_at'] = Carbon::now()->toDateTimeString();
            \DB::table('email_outboxes')->insert($audit);   
        } catch (\Throwable $th) {
            $th = $th->getMessage();
            //throw $th;
        }

        
        $returns = $audit;
        return $returns;

    }



    /**
     * @return void
     */
    public function replaceables()
    {

        $findVariables = [
            // '%customer_name%', #0
        ];

        return $findVariables;
    }

    /**
     * @return array
     * @param integer $template_id
     * @param array $replaceables
     */
    public function template(int $template_id, array $replaceables): array
    {
        // $returns = [];
        // $data = [];
        // $template = [];

        // $sms_template_service = app(CoreSmsTemplateRepository::class);
        // $data['items_per_page'] = 10;
        // $data['filters'] = ['identifier' => ['filter' => 'customer-success-recorded']];
        // $fetch_template = $sms_template_service->index($data);

        // if ($fetch_template['status'] == 1) {
        //     if (!empty($fetch_template['data'][0])) {
        //         $template['subject'] = $fetch_template['data'][0]['subject'];
        //         $template['content'] = $fetch_template['data'][0]['content'];

        //         #string length
        //         $max_string_infobip = 160;
        //         $char_count = strlen($template['content']);
        //         $split_msg_count = ($char_count / $max_string_infobip);
        //         $template['message_count_total'] = $char_count;
        //         $template['send_count'] = ceil($split_msg_count);

        //         #replace
        //         $sms_variables = $this->replaceables();
        //         $replace = str_replace($sms_variables, $replaceables, $template['content']);
        //         $template['content'] = $replace;
        //         $returns = $template;
        //     }
        // }

        // return $returns;
    }




    public function execution($send_details)
    {
        $returns=[];
        #check configuration
        $configuration = $this->configuration();
        
        $from_name = $configuration['from_name'];
        $from = $configuration['from'];
        $to = $send_details['to'];
        $subject = $send_details['subject'];
        $messageBody = $send_details['messageBody'];
       
        try {
            Mail::send([], [], function (Message $message) use ($from_name, $from, $to, $subject, $messageBody) {
                $message->from($from, $from_name);
                $message->to($to);
                $message->subject($subject);
                $message->setBody($messageBody, 'text/html');
            });     
            $returns['status'] = 'success';
        } catch (\Throwable $th) {
            $th = $th->getMessage();
            $returns['status'] = 'failed';
            $returns['remarks'] = $th;
        }


        // execution
        return $returns;
    }
}
