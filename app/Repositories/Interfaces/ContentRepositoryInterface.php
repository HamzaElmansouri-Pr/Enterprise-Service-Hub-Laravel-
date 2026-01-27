<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface ContentRepositoryInterface
{
    public function get(string $contentType): array;
    public function save(string $contentType, array $data): void;
    public function getPageByName(string $name);
}
