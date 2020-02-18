<?php

namespace App\Server\Decorator;

use App\Server\Connection\WsConnection;
use App\Server\Session\SessionProvider;
use Exception;

final class Session extends Decorator
{

    private SessionProvider $sessions;

    public function __construct(
        Handler $handler,
        SessionProvider $sessionProvider
    ) {
        $this->sessions = $sessionProvider;
        parent::__construct($handler);
    }

    public function onOpen(WsConnection $connection): WsConnection
    {
        return parent::onOpen($this->attachSession($connection));
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        return parent::onMessage($this->attachSession($connection), $message);
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        return parent::onError($connection, $exception);
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        return parent::onClose($connection);
    }

    private function attachSession(WsConnection $connection): WsConnection
    {
        $connection->setSessionId($this->sessions->getSessionId($connection));
        return $connection;
    }
}