<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Slider;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SliderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function view(User $user, Slider $slider): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function create(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function update(User $user, Slider $slider): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function delete(User $user, Slider $slider): bool
    {
        return $user->canAccessAdminPanel();
    }
}
