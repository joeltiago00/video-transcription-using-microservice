<?php

namespace Transcription\Responses;

use Aws\Result;

class TranscribeResponse
{
    //TODO:: implement properties setters and getters

    private string $status;

    public function __construct(private readonly Result $response, private readonly string $transcriptionKey = '')
    {
        $this->setStatus();
    }

    private function setStatus(): void
    {
        $this->status = $this->response->get('TranscriptionJob')['TranscriptionJobStatus'];
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getTranscriptionKey(): string
    {
        return $this->transcriptionKey;
    }
}
