<?php

namespace App\Interfaces;

interface AuditTrailInterface
{
    public function index(array $data): array;
    public function store(array $request): array;
    public function edit(int $id): array;
}
