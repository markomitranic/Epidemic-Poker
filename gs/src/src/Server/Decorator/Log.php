<?php

namespace App\Server\Decorator;

use App\Message\Error;
use App\Server\Connection\WsConnection;
use Exception;

class Log extends Decorator
{

    public function onOpen(WsConnection $connection): WsConnection
    {
        \App\Utility\Log::info("New connection!", ['client' => $connection->getRequest()]);
        return parent::onOpen($connection);
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        \App\Utility\Log::info("Incoming message from client.", ['client' => $connection->getRequest(), 'message' => $message]);
        return parent::onMessage($connection, $message);
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        \App\Utility\Log::info("Client left.", ['client' => $connection->getRequest()]);
        return parent::onClose($connection);
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        \App\Utility\Log::error(
            Error::SERVER_ERROR,
            [
                'exception' => $exception,
                'client' => $connection->getRequest()
            ]
        );
        return parent::onError($connection, $exception);
    }

}