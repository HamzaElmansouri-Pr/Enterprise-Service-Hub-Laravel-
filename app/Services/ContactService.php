<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\ContactRepositoryInterface;

class ContactService
{
    protected ContactRepositoryInterface $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getAllContacts(int $perPage = 15)
    {
        return $this->contactRepository->paginate($perPage);
    }

    public function getContactById(int $id)
    {
        return $this->contactRepository->find($id);
    }
    
    public function createContact(array $data)
    {
        return $this->contactRepository->create($data);
    }

    public function deleteContact(int $id): bool
    {
        return $this->contactRepository->delete($id);
    }
}
