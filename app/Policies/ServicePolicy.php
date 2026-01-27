<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function view(User $user, Service $service): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function create(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function update(User $user, Service $service): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function delete(User $user, Service $service): bool
    {
        // Services are critical structure, maybe Admin only?
        return $user->isAdmin();
    }
}
