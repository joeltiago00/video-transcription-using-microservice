<?php

namespace Transcription\AWS\Transcriber\Actions;

use Aws\Result;
use Transcription\AWS\Transcriber\TranscriberClient;

class GetTranscription
{
    public function __construct(private readonly TranscriberClient $client)
    {
    }

    public function handle(string $transcriptionKey): Result
    {
        return $this->client->getTranscription($transcriptionKey);
    }
}
