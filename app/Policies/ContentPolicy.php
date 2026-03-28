<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class ContentPolicy
{
    /**
     * Determine whether the user can manage content.
     */
    public function manage(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    /**
     * Standard methods for resource controllers
     */
    public function viewAny(User $user): bool { return $this->manage($user); }
    public function view(User $user, $model): bool { return $this->manage($user); }
    public function create(User $user): bool { return $this->manage($user); }
    public function update(User $user, $model): bool { return $this->manage($user); }
    public function delete(User $user, $model): bool { return $this->manage($user); }
}
