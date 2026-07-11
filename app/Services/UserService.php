<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CreateUserData;
use App\DTOs\UpdateUserData;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(int $perPage = 15)
    {
        return $this->userRepository->paginate($perPage);
    }

    public function getUserById(int $id)
    {
        return $this->userRepository->find($id);
    }

    public function createUser(CreateUserData $data)
    {
        $attributes = $data->toArray();
        $attributes['password'] = Hash::make($attributes['password']);

        return $this->userRepository->create($attributes);
    }

    public function updateUser(int $id, UpdateUserData $data): bool
    {
        $attributes = $data->toArray();

        if (!empty($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        } else {
            unset($attributes['password']);
        }

        // Check if email changed to reset verification
        if (isset($attributes['email'])) {
            $user = $this->userRepository->find($id);
            if ($user && $user->email !== $attributes['email']) {
                $attributes['email_verified_at'] = null;
            }
        }

        return $this->userRepository->update($id, $attributes);
    }

    /**
     * Set user role (Administrative action only).
     */
    public function assignRole(int $id, string $role): bool
    {
        $user = $this->userRepository->find($id);
        if (!$user) return false;

        // Using forceFill as role is no longer fillable
        $user->forceFill(['role' => $role])->save();
        return true;
    }

    /**
     * Delete a user.
     *
     * This method delegates to the repository. Any permission checks (e.g., preventing an admin
     * from deleting their own account) should be performed in the controller layer.
     */
    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }

    public function toggleActive(int $id): bool
    {
        if ($id === auth()->id()) {
            throw new \Exception('You cannot deactivate your own account.');
        }
        $user = $this->userRepository->find($id);
        if ($user) {
             $this->userRepository->update($id, ['is_active' => !$user->is_active]);
             return !$user->is_active;
        }
        return false;
    }
}
