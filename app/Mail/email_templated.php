<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;
class email_templated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email_info;
    public function __construct($email_info)
    {
        $this->subject = $email_info['subject'];
        $this->message = $email_info['message'];
        $this->extra_template = $email_info['remarks'];



    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('pages.email_body_template.email_templated',[
                'message_content'=>$this->message,
                ])
                ->subject($this->subject);
    }






}
