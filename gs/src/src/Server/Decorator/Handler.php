<?php

namespace App\Server\Decorator;

use App\Server\Connection\WsConnection;
use Exception;

interface Handler
{

    public function onOpen(WsConnection $connection): WsConnection;

    public function onMessage(WsConnection $connection, array $message): WsConnection;

    public function onClose(WsConnection $connection): WsConnection;

    public function onError(WsConnection $connection, Exception $exception): WsConnection;

}