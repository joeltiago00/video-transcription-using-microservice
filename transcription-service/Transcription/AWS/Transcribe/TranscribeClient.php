<?php

namespace Transcription\AWS\Transcribe;

use Aws\TranscribeService\TranscribeServiceClient;
use Closure;
use Illuminate\Support\Str;
use Transcription\AWS\Transcribe\DTO\MakeTranscribeDTO;

class TranscribeClient
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

    public function make(
        string $urlFile,
        string $languageCode = 'pt-BR',
        string $transcriptionKey = '',
        ?Closure $callback = null
    )
    {
        $key = !empty($transcriptionKey) ? $transcriptionKey : Str::uuid()->toString();

        $response = $this->client->startTranscriptionJob([
            'LanguageCode' => $languageCode,
            'Media' => [
                'MediaFileUri' => $urlFile,
            ],
            'TranscriptionJobName' => $key,
        ]);

        if (is_callable($callback)) {
            $responseCallback = $callback($key);
        }
    }
}
