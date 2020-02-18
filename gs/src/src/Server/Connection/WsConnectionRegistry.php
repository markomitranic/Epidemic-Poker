<?php

namespace App\Server\Connection;

use App\Server\Session\SessionProvider;
use App\Server\Session\SessionProviderFactory;
use App\Utility\Log;

class WsConnectionRegistry
{

    /**
     * @var WsConnection[]
     */
    private array $connections = [];

    private SessionProvider $sessions;

    public function __construct()
    {
        $this->sessions = SessionProviderFactory::get();
    }

    /**
     * @throws \Throwable
     */
    public function getConnection(WsConnection $connection): WsConnection
    {
        if (array_key_exists($connection->getSessionId(), $this->connections)) {
            $existingConnection = $this->connections[$connection->getSessionId()];
            $existingConnection->setConnection($connection->getConnection());
            return $existingConnection;
        }

        Log::info('No matching connections exist, add new connection to the registry.');
        $this->connections[$connection->getSessionId()] = $connection;
        return $connection;
    }

    public function close(WsConnection $connection): void
    {
        if (array_key_exists($connection->getSessionId(), $this->connections)) {
            unset($this->connections[$connection->getSessionId()]);
        }
        $connection->getConnection()->close();
        $connection->setConnection(null);
    }

}