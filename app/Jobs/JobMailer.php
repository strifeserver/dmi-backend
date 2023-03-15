<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\MailService;
class JobMailer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $details;
    public $mailer_config;
    public function __construct($params)
    {
        $this->details = $params['details'];
        $this->mailer_config = $params['mailer_config'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail_service = App(MailService::class);
        $execute = $mail_service->execution($this->details,$this->mailer_config);
    }
}
