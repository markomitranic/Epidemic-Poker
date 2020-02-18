<?php

namespace App\Server\Decorator;

use App\Server\Connection\WsConnection;
use Exception;

class BaseHandler implements Handler
{

    public function onOpen(WsConnection $connection): WsConnection
    {
        return $connection;
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        return $connection;
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        return $connection;
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        return $connection;
    }
}