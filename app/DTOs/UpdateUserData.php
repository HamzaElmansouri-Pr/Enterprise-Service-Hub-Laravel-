<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class UpdateUserData
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public ?string $image = null,
        public ?string $role = null,
        public ?bool $is_active = null,
    ) {}

    /**
     * Create from validated request array.
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'] ?? null,
            image: $data['image'] ?? null,
            role: $data['role'] ?? null,
            is_active: array_key_exists('is_active', $data) ? (bool) $data['is_active'] : null,
        );
    }

    /**
     * Convert to array for Eloquent mass-assignment.
     * Excludes null password so it won't be overwritten.
     */
    public function toArray(): array
    {
        $result = [
            'name' => $this->name,
            'email' => $this->email,
        ];

        if ($this->password !== null) {
            $result['password'] = $this->password;
        }

        if ($this->image !== null) {
            $result['image'] = $this->image;
        }

        if ($this->role !== null) {
            $result['role'] = $this->role;
        }

        if ($this->is_active !== null) {
            $result['is_active'] = $this->is_active;
        }

        return $result;
    }
}
