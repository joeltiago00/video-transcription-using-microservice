<?php

namespace Transcription\AWS\Transcribe\Responses;

class TranscribeResponse
{
    private string $status;

    public function __construct(private readonly mixed $response)
    {
        $this->setStatus();
    }

    private function setStatus(): void
    {
        $this->status = $this->response->get('TranscriptionJob')['TranscriptionJobStatus'];
    }
}
