<?php

namespace App\Server\Decorator;

use App\Server\Connection\WsConnection;
use App\Server\Connection\WsConnectionRegistry;
use App\Server\Session\SessionProvider;

final class Session extends Decorator
{

    private SessionProvider $sessions;

    private WsConnectionRegistry $connectionRegistry;

    public function __construct(
        Handler $handler,
        SessionProvider $sessionProvider,
        WsConnectionRegistry $connectionRegistry
    ) {
        $this->sessions = $sessionProvider;
        $this->connectionRegistry = $connectionRegistry;
        parent::__construct($handler);
    }

    public function onOpen(WsConnection $connection): WsConnection
    {
        $connection->setSessionId(
            $this->sessions->getSessionId($connection)
        );

        $connection = $this->connectionRegistry->getConnection($connection);
        return parent::onOpen($connection);
    }

}