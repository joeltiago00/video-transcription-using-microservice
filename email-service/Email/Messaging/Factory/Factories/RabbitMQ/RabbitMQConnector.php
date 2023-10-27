<?php

namespace Email\Messaging\Factory\Factories\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQConnector
{

    private function __construct(public readonly AMQPStreamConnection $connection)
    {
    }

    public static function get(string $host, string $port, string $user, string $password, $vhost = ''): RabbitMQConnection
    {
        //TODO:: handle with vhost
        return new RabbitMQConnection(
            new AMQPStreamConnection($host, $port, $user, $password)
        );
    }
}
