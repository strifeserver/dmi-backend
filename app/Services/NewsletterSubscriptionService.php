<?php

namespace App\Services;

use App\Repositories\NewsletterSubscriptionRepository;

class NewsletterSubscriptionService
{
    public function __construct(NewsletterSubscriptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): array
    {
        $data = [];
        $itemsPerPage = request('itemsPerPage') ?? 10;
        $filter = request('filter') ?? [];
        $pagination = request('pagination') ?? 0;
        if (empty($pagination)) {
            $pagination = 0;
        }
        $data['pagination'] = $pagination;
        $data['items_per_page'] = $itemsPerPage;
        $data['filters'] = $filter;
        $execution = $this->repository->index($data);

        $response = $this->api_service->api_returns($execution);
        return $response;
    }

    public function getactivesubscribers(){
        $data['filters'] = json_encode(['status'=>['filter'=>1]]);
        $execution = $this->repository->index($data);

        return $execution;
    }
    public function subscribe($request)
    {
        // Process Data
        $request['status'] = 1;
        $return = $this->repository->subscribe($request);
        return $return;
    }
    public function unsubscribe($request)
    {
        // Process Data
        $request['status'] = 0;
        $update = $this->repository->unsubscribe($request);
        return $update;
    }

}
