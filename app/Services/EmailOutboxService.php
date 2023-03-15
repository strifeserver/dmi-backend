<?php

namespace App\Services;

use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use App\Repositories\EmailOutboxRepository;
use App\Services\ApiService;
use App\Services\DealerService;
use App\Services\ExportService;
use App\Services\MailService;

class EmailOutboxService
{

    /**
     * @param EmailOutboxRepository $repository
     */
    public function __construct(EmailOutboxRepository $repository, ApiService $api_service)
    {
        $this->repository = $repository;
        $this->api_service = $api_service;
    }

    public function logged_in_user()
    {
        $user_id = Auth::id();

    }

    /**
     * @return array
     * @param integer $id
     */
    public function index(): array
    {

        $data = [];
        $itemsPerPage = request('itemsPerPage') ?? 10;
        $filter = request('filter') ?? [];
        $sort = request('sort') ?? [];
        $pagination = request('pagination');
        if (empty($pagination)) {
            $pagination = 0;
        }

        $data['items_per_page'] = $itemsPerPage;
        $data['filters'] = $filter;
        $data['sort'] = $sort;
        $data['pagination'] = $pagination;
        $execution = $this->repository->index($data);
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    /**
     * @return array
     * @param array $request
     */
    public function store(array $request): array
    {
        $request['created_by'] = request("hash") ?? '';
        $request['updated_by'] = request("hash") ?? '';
        $execution = $this->repository->store($request);
        if ($execution['status'] == 1) {
            $audit_data = ['incoming_data' => $request];
            // $audit = $this->audit_service->store($audit_data);
        }
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    /**
     * @return array
     * @param integer $Id
     */
    public function edit(int $Id): array
    {
        $execution = $this->repository->edit($Id);
        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    /**
     * @return void
     */
    public function fillables()
    {
        $execution = $this->repository->fillables();
        return $execution;
    }

    public function export($data)
    {

        $returns = ['status' => 0];
        $get_data = [];
        $get_data['filters'] = $data->filter ?? '';
        $get_data['headers'] = $data->header ?? [];
        $rows = [];
        $row_count = 0;
        $execution = $this->repository->index($get_data);
        if (!empty($execution)) {
            $rows = $execution['data'];
            $row_count = count($rows);
        }

        $exportService = app(ExportService::class);
        $unique_id = Str::random(5);
        $import_mode = 'audit_trail';
        $filename = $import_mode . '_export_' . $unique_id . '_' . date('Y-m-d');
        $headers = $data['headers'] ?? $this->fillables();

        $data = [
            'filename' => $filename,
            'mode' => $import_mode,
            'headers' => $headers,
            'rows' => $rows,
        ];
        if ($row_count > 0) {
            $exporting = $exportService->create($data);
            if ($exporting['status'] == 'success') {
                $returns['status'] = 1;
                $returns['data']['export_file_csv'] = url('/') . '/storage/' . $filename . '.csv';
            }
        } else {
            $returns['status'] = 1;

            // $returns['result']['export_result'] = 'no data found';
        }
        $returns = $this->api_service->api_returns($returns);

        return $returns;
    }

    public function dev_display()
    {
        $mode = request('mode');
      
        $returns = [];
        if($mode == 'email_settings'){
            
            $mailer = [];
            $mailer['mail_driver'] = Config::get('config.mail_driver');
            $mailer['mail_host'] = Config::get('config.mail_host');
            $mailer['mail_port'] = Config::get('config.mail_port');
            $mailer['mail_username'] = Config::get('config.mail_username');
            $mailer['mail_username_a'] = Config::get('config.mail_username_a');
            $mailer['MAIL_USERNAME_B'] = Config::get('config.MAIL_USERNAME_B');
            $mailer['mail_password'] = Config::get('config.mail_password');
            $mailer['mail_encryption'] = Config::get('config.mail_encryption');
            $mailer['mail_from_address'] = Config::get('config.mail_from_address');
            $mailer['mail_mode'] = 'env';
            $returns['mailer_info'] = $mailer;
        }


        if ($mode == 'test_dealer_email') {
            #Do Mailer  
            $dealerService = app(DealerService::class);
            $fetchDealer = $dealerService->index([]);
            if ($fetchDealer) {
                $toSendEmails = [];
                if (!empty($fetchDealer['result'])) {
                    $dealers = array_column($fetchDealer['result'], 'email');
                    foreach ($dealers as $key => $raw_email) {
                        $r_email = explode(',', $raw_email);
                        foreach ($r_email as $key => $r_emails) {
                            $toSendEmails[] = trim($r_emails);
                        }
                    }
                }
                $toSendEmails = array_unique($toSendEmails);
                if (!empty($toSendEmails)) {
                    $email_service = app(MailService::class);
                    $send_email = $email_service->send($toSendEmails, '', '', '', 'dealer-import-success', '', );
                    $returns = $send_email;
                    
                }
            }
        }


        if($mode == 'check_changes'){
            $returns = 'TEWST';
        }

        if($mode == 'all_config'){
            $returns = Config::get('config');
        }

        return $returns;

    }

}
