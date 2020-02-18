<?php

namespace App\Server\Decorator;

use App\Client\ClientRegistry;
use App\Server\Connection\WsConnection;
use Exception;

final class Client extends Decorator
{

    private ClientRegistry $clientRegistry;

    public function __construct(
        Handler $handler,
        ClientRegistry $clientRegistry
    ) {
        $this->clientRegistry = $clientRegistry;
        parent::__construct($handler);
    }

    public function onOpen(WsConnection $connection): WsConnection
    {
        return parent::onOpen($this->attachClient($connection));
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        return parent::onMessage($this->attachClient($connection), $message);
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        return parent::onError($connection, $exception);
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        return parent::onClose($connection);
    }

    private function attachClient(WsConnection $connection): WsConnection
    {
        $connection->setClient($this->clientRegistry->getOrCreate($connection));
        return $connection;
    }
}