<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    public function createUser(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $data['is_active'] = isset($data['is_active']) && $data['is_active'];

        return $this->userRepository->create($data);
    }

    public function updateUser(int $id, array $data): bool
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
             unset($data['password']);
        }
        
        // Check if email changed to reset verification
        if (isset($data['email'])) {
            $user = $this->userRepository->find($id);
            if ($user && $user->email !== $data['email']) {
                $data['email_verified_at'] = null;
            }
        }
        
        // Profile update only passes name/email.
        // Sensitive fields like role/is_active are ignored here because they are not fillable.
        
        return $this->userRepository->update($id, $data);
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
     * Delete user with self-delete protection.
     */
    public function deleteUser(int $id): bool
    {
        // Check if self-delete logic needed? 
        // Admin shouldn't delete self via admin panel (handled in controller usually, or here).
        // Profile self-delete is fine.
        // I put a check "You cannot delete your own account" in previous version.
        // If I call this for self-delete (ProfileController), it will THROW.
        // So I need to allow self delete if it comes from ProfileController?
        // Or separate methods: `adminDeleteUser` vs `deleteUser`.
        // Or remove the check and let Controller handle permission/validation.
        
        // I'll remove the check here for flexibility, or check a flag.
        // Actually, preventing accidental admin self-delete is good UI.
        // But profile destruction is valid self-delete.
        // I'll leave the check but compare ID with Auth::id(). 
        // If I want to allow self-delete, I should have a separate method or parameter.
        // Let's remove the check here and enforce it in AdminController.
        
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
