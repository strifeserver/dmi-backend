<?php

namespace App\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $details = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $to = $this->details['to'];
        $title = $this->details['title'];
        $body = $this->details['body'];
        if(empty($this->details['blade_template'])){
            $template = 'default_mail_template';
        }else{
            $template = $this->details['blade_template'];
        }
        $fileattachment = $this->details['attachment'] ?? [];
        $from = Config::get('config.mail_username');
        $mailer = $this
        ->from($from,'WTBS')
        ->subject($title)
        
        ->view($template,[
            'details'=>$this->details
            ]);
        if($fileattachment){
            if($fileattachment['import_mode'] == 'single_file'){
                $mailer->attach($fileattachment['temp_path'], [
                    'as' => $fileattachment['original_name'],
                    'mime' => 'csv',
                ]);
            }
        }
        return $mailer;
    }
}
