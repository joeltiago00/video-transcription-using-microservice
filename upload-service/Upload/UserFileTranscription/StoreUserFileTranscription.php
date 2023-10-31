<?php

namespace Upload\UserFileTranscription;

use App\Models\UserFileTranscription;
use Repositories\UserFileTranscription\UserFileTranscriptionRepository;
use Upload\UserFileTranscription\DTO\UserFileTranscriptionDTO;

class StoreUserFileTranscription
{
    public function __construct(private readonly UserFileTranscriptionRepository $userFileTranscriptionRepository)
    {
    }

    public function handle(int $userId, int $fileId, int $transcriptionId): UserFileTranscription
    {
        return $this->userFileTranscriptionRepository
            ->store(new UserFileTranscriptionDTO($userId, $fileId, $transcriptionId));
    }
}
