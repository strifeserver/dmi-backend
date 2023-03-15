<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\email_templated;
use Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    private $send_mail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_mail)
    {
        $this->send_mail = $send_mail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        error_reporting(0);
        $data = $this->send_mail;
  
        $send_to = $data['sendto'];
        $email = new email_templated($data);  
        $mailer = Mail::to($send_to)->send($email);

        \DB::table('core_email_outboxes')->insert([
            'email' => $data['sendto'],
            'subject' => $data['subject'],
            'content' => $data['message'],
            'remarks' => 'SENT',
            'created_by' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }

    public function failed($e)
    {
        $data = $this->config;
     
        \DB::table('core_email_outboxes')->insert([
            'email' => $data['sendto'],
            'subject' => $data['subject'],
            'content' => '<See queued>',
            'sent_by' => 0,
            'remarks' => 'FAILED:' . $e->getMessage(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
