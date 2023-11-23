<?php

namespace Transcription\Contracts;

use Transcription\Responses\TranscribeResponse;

interface ITranscribe
{
    public function startTranscription(string $file): TranscribeResponse;

    public function getTranscription(string $transcriptionKey): string;
}
