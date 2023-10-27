<?php declare(strict_types=1);

namespace Email\Messaging\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class MessagingException extends Exception
{
    public static function serviceNotImplemented(string $messagingService): self
    {
        return new self(
            trans('exceptions.messaging-service.not-implemented', ['messaging_service' => $messagingService]),
            Response::HTTP_INTERNAL_SERVER_ERROR,
        );
    }
}
