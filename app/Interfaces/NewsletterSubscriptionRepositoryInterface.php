<?php

namespace App\Interfaces;

interface NewsletterSubscriptionRepositoryInterface
{
    public function subscribe($request);
    public function unsubscribe($request);
}