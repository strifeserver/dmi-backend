<?php

namespace App\Services;

// use Illuminate\Support\Facades\Config;
// use Mail;
use App\Emails\SendMail;
// use AppCoreEmailTemplate;
// use App\Jobs\JobMailer;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\CoreEmailTemplate;
use App\CoreEmailOutbox;
use Illuminate\Support\Facades\Log;
class MailService
{

    public function position_replaceables($replaceables)
    {
        $formatted = [];
        if (!empty($replaceables)) {
            $highest_key = max(array_keys($replaceables)) + 1;
            for ($i = 0; $i < $highest_key; $i++) {
                if (!empty($replaceables[$i])) {
                    $formatted[] = $replaceables[$i];
                } else {
                    $formatted[] = '';
                }
            }
        }
        return $formatted;
    }

    public function default_mail_configs()
    {
        $returns = [];
        #check username
        $mailer_uname = Config::get('api.mail_username');
        $returns['mail_driver'] = Config::get('api.mail_driver');
        $returns['mail_host'] = Config::get('api.mail_host');
        $returns['mail_port'] = Config::get('api.mail_port');
        $returns['mail_username'] = Config::get('api.mail_username');
        $returns['mail_password'] = Config::get('api.mail_password');
        $returns['mail_encryption'] = Config::get('api.mail_encryption');
        $returns['mail_from_address'] = Config::get('api.mail_from_address');
        $returns['mail_mode'] = 'env';
        return $returns;
    }

    /**
     * @return void
     */
    public function replaceables()
    {

        $findVariables = [
            '{{ website_link }}', #0
            '{{ customer_name }}', #1
            '{{ otp }}', #2
            '{{ expiry }}', #3
            '{{ survey_id }}', #4
        ];

        return $findVariables;
    }

    /**
     * @return array
     * @param string $template_id
     * @param array $replaceables
     */
    public function template(string $template_id, array $replaceables): array
    {
        $returns = [];
        $template = [];
        $get_template = CoreEmailTemplate::where('identifier', '=', $template_id)->first();
        if ($get_template) {
            $template = $get_template->toArray();
        }
        $sms_variables = $this->replaceables();
        if (!empty($template['content'])) {
            $replaceables = $this->position_replaceables($replaceables);
            $replace = str_replace($sms_variables, $replaceables, $template['content']);
            $template['content'] = html_entity_decode($replace);
        }

        $returns = $template;
        return $returns;
    }
    /**
     * @return void
     * @param string $to
     * @param string $title
     * @param string $body
     * @param string|null $attached_file
     * @param string $template
     * @param string $blade_template
     * @param array $replaceables
     */
    public function send($to, string $title, string $body = '', $attached_file = [], string $template = '', string $blade_template, array $replaceables = [])
    {

      
        try {
            $queue_connection = Config::get('System.QUEUE_CONNECTION');
            $process_type = ($queue_connection == 'database') ? 1 : 0;

            if (empty($body)) {
                $get_template = $this->template($template, $replaceables);
                if (!empty($get_template)) {
                    $title = $get_template['subject'];
                    $body = $get_template['content'];
                }
            }

            if (!empty($to) && !empty($body) && !empty($title)) {
                $details = [
                    'to' => $to,
                    'title' => $title,
                    'body' => $body,
                    'attachment' => $attached_file ?? null,
                    'template' => $template,
                    'blade_template' => $blade_template,
                ];

                if ($process_type == 0) {
                    $execute = $this->execution($details, $this->default_mail_configs());
                    $returns = [
                        'status' => $execute['status'],
                        'code' => 200,
                        'message' => 'Email sent successfully',
                        'result' => '',
                    ];
                } else if ($process_type == 1) {
                    $dispatchData = ['details' => $details, 'mailer_config' => $this->default_mail_configs()];
                    $dispatchJob = JobMailer::dispatch($dispatchData);
                    $returns = [
                        'status' => 1,
                        'code' => 200,
                        'message' => '',
                        'result' => ['mail_info' => ['status' => 'In Queue']],
                    ];
                }

                try {
                    $emailOutbox = new CoreEmailOutbox;
                    $emailOutbox->email = json_encode($to);
                    $emailOutbox->subject = $title;
                    $emailOutbox->content = $body;
                    // $emailOutbox->remarks = json_encode($details);
                    $emailOutbox->save();
                } catch (\Throwable $th) {
                    //throw $th;
                }




                // Store outbox data
                // $outbox_data = [
                //     'subject' => $title,
                //     'send_to' => json_encode($to),
                //     'template_id' => $template,
                //     'content' => $body,
                //     'raw_content' => json_encode($details),
                // ];
                // $outbox_service = app(EmailOutboxService::class);
                // $outbox = $outbox_service->store($outbox_data);

            } else {
                $returns = [
                    'status' => 0,
                    'code' => 400,
                    'message' => '',
                    'result' => '',
                ];
            }
        } catch (\Throwable $th) {
            $errorMessage = $th->getMessage();
            Log::error($errorMessage);
            $returns = [
                'status' => 'error',
                'code' => 400,
                'message' => $errorMessage,
                'result' => '',
            ];

        }
        return $returns;
    }

    public function execution($details, $mailer_config)
    {
        $returns = [];

        #check mailer configuration

        if ($mailer_config['mail_mode'] == 'test') {
            $transport = app('swift.transport');
            $smtp = $transport->driver($mailer_config['mail_driver']);
            $smtp->setHost($mailer_config['mail_host']);
            $smtp->setPort($mailer_config['mail_port']);
            $smtp->setUsername($mailer_config['mail_username']);
            $smtp->setPassword($mailer_config['mail_password']);
            $smtp->setEncryption($mailer_config['mail_encryption']);
        }
        $mailer = Mail::to($details['to'])->queue(new SendMail($details));

        try {
            $returns['status'] = 1;
        } catch (\Throwable $th) {
            $returns['status'] = 0;
            $returns['result']['error_details'] = @$th->getMessage();
        }

        if (!empty($returns['error_details'])) {
            if ($returns['error_details'] == 'Address in mailbox given [] does not comply with RFC 2822, 3.6.2.') {
                $returns['result'] = ['error_message' => 'Email config is not set', 'error_raw' => $returns['error_details']];
            }
        }

        $mailer_uname = Config::get('System.mail_username');
        $returns['result']['env_mailer_username'] = $mailer_uname;
        $returns['result']['test_mailer_username'] = $mailer_config['mail_username'];

        return $returns;
    }
}
