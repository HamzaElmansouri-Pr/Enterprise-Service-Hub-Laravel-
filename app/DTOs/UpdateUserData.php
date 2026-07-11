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

        return $result;
    }
}
