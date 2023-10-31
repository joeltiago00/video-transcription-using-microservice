<?php

namespace Repositories\Transcription;

use App\Models\Transcription;

interface TranscriptionRepository
{
    public function store(): Transcription;
}
