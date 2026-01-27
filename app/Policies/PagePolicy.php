<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function update(User $user, Page $page): bool
    {
        return $user->canAccessAdminPanel();
    }
}
