<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface ContactRepositoryInterface extends RepositoryInterface
{
     public function markAllAsRead(): bool;
}
