<?php

namespace Transcription\AWS\Transcriber;

use Aws\Result;
use Aws\TranscribeService\TranscribeServiceClient;

class TranscriberClient
{
    private TranscribeServiceClient $client;

    public function __construct(
        private readonly string $region,
        private readonly string $accessKey,
        private readonly string $secretKey
    )
    {
        $this->client = new TranscribeServiceClient([
            'region' => $this->region,
            'version' => 'latest',
            'credentials' => [
                'key' => $this->accessKey,
                'secret' => $this->secretKey
            ]
        ]);
    }

    public function startTranscription(
        string $urlFile,
        string $transcriptionKey,
        bool   $identifyMultipleLanguages = true
    ): Result
    {
        return $this->client->startTranscriptionJob([
            'Media' => [
                'MediaFileUri' => $urlFile,
            ],
            'IdentifyMultipleLanguages' => $identifyMultipleLanguages,
            'TranscriptionJobName' => $transcriptionKey,
        ]);
    }

    public function getTranscription(string $transcriptionKey): Result
    {
        return $this->client->getTranscriptionJob(['TranscriptionJobName' => $transcriptionKey]);
    }
}
