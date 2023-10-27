<?php

namespace Tests\Unit\Messaging;

use Email\Messaging\Exceptions\MessagingException;
use Email\Messaging\MessagingResolver;
use Email\Messaging\Messengers\RabbitMQ\RabbitMQ;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MessagingResolverTest extends TestCase
{
    public function testSuccessInstanceOfRabbitMq()
    {
        $this->assertInstanceOf(RabbitMQ::class, MessagingResolver::resolve());
    }

    public function testFailServiceNotImplemented()
    {
        $invalidMessagingService = 'dynamodb';

        $this->expectException(MessagingException::class);
        $this->expectExceptionMessage(sprintf('Message service type %s is not implemented.', $invalidMessagingService));

        Config::set('messaging.default', $invalidMessagingService);

        MessagingResolver::resolve();
    }
}
