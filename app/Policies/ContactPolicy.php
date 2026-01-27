<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function view(User $user, Contact $contact): bool
    {
        return $user->canAccessAdminPanel();
    }

    public function delete(User $user, Contact $contact): bool
    {
        return $user->isAdmin(); // Only Admin deletes contacts? Or allow editor. Let's say Admin.
    }
}
