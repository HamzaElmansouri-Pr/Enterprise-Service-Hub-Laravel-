<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\TcRequestRepositoryInterface;
use Illuminate\Http\UploadedFile;

class TcRequestService
{
    protected TcRequestRepositoryInterface $tcRequestRepository;

    public function __construct(TcRequestRepositoryInterface $tcRequestRepository)
    {
        $this->tcRequestRepository = $tcRequestRepository;
    }

    public function getAllTcRequests(int $perPage = 15)
    {
        return $this->tcRequestRepository->paginate($perPage);
    }

    public function getTcRequestById(int $id)
    {
        return $this->tcRequestRepository->find($id);
    }
    
    public function createTcRequest(array $data, ?UploadedFile $attachedFile = null)
    {
        if ($attachedFile) {
            $fileName = time() . '_' . $attachedFile->getClientOriginalName();
            $tcDir = public_path('tc');
            if (!file_exists($tcDir)) {
                mkdir($tcDir, 0755, true);
            }
            $attachedFile->move($tcDir, $fileName);
            $data['attached_file'] = 'tc/' . $fileName;
        }
        
        return $this->tcRequestRepository->create($data);
    }

    public function deleteTcRequest(int $id): bool
    {
        return $this->tcRequestRepository->delete($id);
    }
}
