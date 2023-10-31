<?php

namespace Repositories\UserFileTranscription;

use App\Models\UserFileTranscription;
use Upload\UserFileTranscription\DTO\UserFileTranscriptionDTO;

interface UserFileTranscriptionRepository
{
    public function store(UserFileTranscriptionDTO $dto): UserFileTranscription;
}
