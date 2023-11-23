<?php

namespace Transcription\Transcriber\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class TranscriberException extends Exception
{
    public static function invalidService(string $service): self
    {
        return new self(
            trans('exceptions.transcriber.invalid-service', ['service' => $service]),
            Response::HTTP_INTERNAL_SERVER_ERROR
        );
    }
}
