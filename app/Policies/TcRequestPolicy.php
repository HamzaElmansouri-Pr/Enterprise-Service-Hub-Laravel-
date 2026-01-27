<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\TcRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TcRequestPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function view(User $user, TcRequest $tcRequest): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function create(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function update(User $user, TcRequest $tcRequest): bool
    {
        return $user->isAdmin(); // Or canAccessAdminPanel depending on requirements, usually Admin for state changes
    }

    public function delete(User $user, TcRequest $tcRequest): bool
    {
        return $user->isAdmin();
    }
}
