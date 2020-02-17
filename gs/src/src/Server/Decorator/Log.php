<?php

namespace App\Server\Decorator;

use App\Server\Connection\WsConnection;
use Exception;

class Log implements Handler
{

    public function onOpen(WsConnection $connection): WsConnection
    {
        \App\Utility\Log::info("New connection!", ['client' => $connection->getRequest()]);
        return $connection;
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        \App\Utility\Log::info("Incoming message from client.", ['client' => $connection->getRequest(), 'message' => $message]);
        return $connection;
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        \App\Utility\Log::info("Client left.", ['client' => $connection->getRequest()]);
        return $connection;
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        \App\Utility\Log::error(
            "Error state.",
            [
                'exception' => $exception,
                'client' => $connection->getRequest()
            ]
        );
        return $connection;
    }

}