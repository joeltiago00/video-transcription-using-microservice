<?php

namespace Transcription\AWS\Transcriber;

use Transcription\AWS\Transcriber\Actions\GetTranscription;
use Transcription\AWS\Transcriber\Actions\GetTranscriptionSync;
use Transcription\AWS\Transcriber\Actions\StartTranscription;
use Transcription\Contracts\ITranscribe;
use Transcription\Responses\TranscribeResponse;

class Transcriber implements ITranscribe
{
    private StartTranscription $startTranscription;
    private GetTranscriptionSync $getTranscriptionSync;

    public function __construct(private readonly TranscriberClient $client)
    {
        $this->startTranscription = new StartTranscription($this->client);

        $this->getTranscriptionSync = new GetTranscriptionSync(new GetTranscription($this->client));
    }

    public function startTranscription(string $file): TranscribeResponse
    {
        return $this->startTranscription->handle($file);
    }

    public function getTranscription(string $transcriptionKey): string
    {
        return $this->getTranscriptionSync->handle($transcriptionKey);
    }
}
