<?php

namespace App\Interfaces;

interface EmailOutboxInterface
{
    public function index(array $data): array;
    public function store(array $request): array;
    public function edit(int $id): array;
}
