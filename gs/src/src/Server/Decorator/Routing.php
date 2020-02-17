<?php

namespace App\Server\Decorator;

use App\Client\ClientRegistry;
use App\Server\Connection\WsConnection;
use App\Utility\ConfigurationProvider;
use Exception;

class Routing extends Decorator
{

    private ClientRegistry $clientRegistry;

    public function __construct(Handler $handler, ClientRegistry $clientRegistry)
    {
        $this->clientRegistry = $clientRegistry;
        parent::__construct($handler);
    }

    public function onOpen(WsConnection $connection): WsConnection
    {
        $client = $this->clientRegistry->get($connection);

        $connection->getConnection()->send('WELCOME, friend!');
        return parent::onOpen($connection);
    }

    public function onMessage(WsConnection $connection, string $message): WsConnection
    {
        $connection->getConnection()->send(sprintf(
            'Pong: %s | Shard: %s | SessionID: %s',
            $message,
            ConfigurationProvider::get(ConfigurationProvider::SHARD_NAME),
            $connection->getSessionId()
        ));
        return parent::onMessage($connection, $message);
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        $connection->close();
        return parent::onClose($connection);
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        $connection->getConnection()->close();
        return parent::onError($connection, $exception);
    }

}