<?php

namespace Transcription\AWS\Transcriber;

use Transcription\Contracts\ITranscribe;

class TranscriberFactory
{
    public static function create(): ITranscribe
    {
        return new Transcriber(
            new TranscriberClient(
                config('aws.transcriber.default_region'),
                config('aws.transcriber.access_key'),
                config('aws.transcriber.secret_key')
            ));
    }
}
