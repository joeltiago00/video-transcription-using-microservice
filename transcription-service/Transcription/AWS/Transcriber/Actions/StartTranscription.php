<?php

namespace Transcription\AWS\Transcriber\Actions;

use Aws\Result;
use Illuminate\Support\Str;
use Transcription\AWS\Transcriber\TranscriberClient;
use Transcription\Responses\TranscribeResponse;

class StartTranscription
{
    public function __construct(private readonly TranscriberClient $client)
    {
    }

    public function handle(string $urlFile): TranscribeResponse
    {
        $transcriptionKey = Str::uuid()->toString();

        $response = $this->client->startTranscription(
            $urlFile,
            $transcriptionKey,
            config('filesystems.disks.s3.bucket'),
        );

        return new TranscribeResponse($response, $transcriptionKey);
    }
}
