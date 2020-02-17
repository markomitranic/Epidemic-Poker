<?php

namespace App\Server\Decorator;

use App\Client\ClientRegistry;
use App\Message\Auth\Handler as AuthHandler;
use App\Message\Auth\Message;
use App\Server\Connection\WsConnection;
use App\Server\Connection\WsConnectionRegistry;
use App\Server\Session\SessionProvider;
use Exception;

final class Session extends Decorator
{

    private ClientRegistry $clientRegistry;

    private SessionProvider $sessions;

    private WsConnectionRegistry $connectionRegistry;

    public function __construct(
        Handler $handler,
        ClientRegistry $clientRegistry,
        SessionProvider $sessionProvider,
        WsConnectionRegistry $connectionRegistry
    ) {
        $this->clientRegistry = $clientRegistry;
        $this->sessions = $sessionProvider;
        $this->connectionRegistry = $connectionRegistry;
        parent::__construct($handler);
    }

    public function onOpen(WsConnection $connection): WsConnection
    {
        return parent::onOpen($this->auth($connection));
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        return parent::onMessage($this->auth($connection), $message);
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        return parent::onError($this->auth($connection), $exception);
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        $connection = $this->auth($connection);
        $this->connectionRegistry->close($connection);
        return parent::onClose($connection);
    }

    private function auth(WsConnection $connection): WsConnection
    {
        $connection->setSessionId($this->sessions->getSessionId($connection));
        return $this->connectionRegistry->getConnection($connection);
    }
}