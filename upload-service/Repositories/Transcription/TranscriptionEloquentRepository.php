<?php

namespace Repositories\Transcription;

use App\Models\Transcription;

class TranscriptionEloquentRepository implements TranscriptionRepository
{
    public function __construct(private readonly Transcription $model)
    {
    }

    public function store(): Transcription
    {
        /** @var Transcription */
        return $this->model
            ->newQuery()
            ->create();
    }
}
