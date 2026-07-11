<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class CreateUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $image = null,
        public string $role = 'editor',
        public bool $is_active = true,
    ) {}

    /**
     * Create from validated request array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            image: $data['image'] ?? null,
            role: $data['role'] ?? 'editor',
            is_active: isset($data['is_active']) && $data['is_active'],
        );
    }

    /**
     * Convert to array for Eloquent mass-assignment.
     */
    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'image' => $this->image,
            'role' => $this->role,
            'is_active' => $this->is_active,
        ], fn ($v) => $v !== null);
    }
}
