<?php

namespace Upload\Transcription;

use App\Models\Transcription;
use Repositories\Transcription\TranscriptionRepository;

class StoreTranscription
{
    public function __construct(private readonly TranscriptionRepository $transcriptionRepository)
    {
    }

    public function handle(): Transcription
    {
        return $this->transcriptionRepository->store();
    }
}
