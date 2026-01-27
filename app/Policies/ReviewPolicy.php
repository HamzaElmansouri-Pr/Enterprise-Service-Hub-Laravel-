<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function view(User $user, Review $review): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function create(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function update(User $user, Review $review): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function delete(User $user, Review $review): bool
    {
        return $user->canAccessAdminPanel();
    }
    
    public function approve(User $user, Review $review): bool
    {
        return $user->canAccessAdminPanel();
    }
}
