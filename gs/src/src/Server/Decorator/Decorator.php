<?php

namespace App\Server\Decorator;

use App\Server\Connection\WsConnection;
use Exception;

abstract class Decorator implements Handler
{

    protected Handler $handler;

    public function __construct(Handler $handler)
    {
        $this->handler = $handler;
    }

    public function onOpen(WsConnection $connection): WsConnection
    {
        return $this->handler->onOpen($connection);
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        return $this->handler->onMessage($connection, $message);
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        return $this->handler->onClose($connection);
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        return $this->handler->onError($connection, $exception);
    }
}