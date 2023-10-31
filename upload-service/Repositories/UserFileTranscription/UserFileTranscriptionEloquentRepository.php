<?php

namespace Repositories\UserFileTranscription;

use App\Models\UserFileTranscription;
use Upload\UserFileTranscription\DTO\UserFileTranscriptionDTO;

class UserFileTranscriptionEloquentRepository implements UserFileTranscriptionRepository
{
    public function __construct(private readonly UserFileTranscription $model)
    {
    }

    public function store(UserFileTranscriptionDTO $dto): UserFileTranscription
    {
        /** @var UserFileTranscription */
        return $this->model
            ->newQuery()
            ->create($dto->toArray());
    }
}
