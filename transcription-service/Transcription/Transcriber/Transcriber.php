<?php

namespace Transcription\Transcriber;

use Transcription\AWS\Transcriber\Transcriber as AwsTranscriber;
use Transcription\Contracts\ITranscribe;
use Transcription\Transcriber\Exceptions\TranscriberException;

class Transcriber
{
    public static function service(string $service = 'aws'): ITranscribe
    {
        return match ($service) {
            'aws' => app(AwsTranscriber::class),
            default => throw TranscriberException::invalidService($service)
        };
    }
}
