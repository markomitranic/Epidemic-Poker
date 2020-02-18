<?php

namespace App\Server\Connection;

use App\Utility\Log;

class WsConnectionRegistry
{

    /**
     * @var WsConnection[]
     */
    private array $connections = [];

    /**
     * @throws \Throwable
     */
    public function get(WsConnection $connection): WsConnection
    {
        if (array_key_exists($this->getConnectionId($connection), $this->connections)) {
            $existingConnection = $this->connections[$this->getConnectionId($connection)];
            $existingConnection->setConnection($connection->getConnection());
            $existingConnection->setFreshConnection(false);
            return $existingConnection;
        }
        throw new \Exception('No matching connections exist.');
    }

    public function create(WsConnection $connection): WsConnection
    {
        Log::info('No matching connections exist, add new connection to the registry.');
        $this->connections[$this->getConnectionId($connection)] = $connection;
        $connection->setFreshConnection(true);
        return $connection;
    }

    public function close(WsConnection $connection): void
    {
        if (array_key_exists($this->getConnectionId($connection), $this->connections)) {
            unset($this->connections[$this->getConnectionId($connection)]);
        }
        $connection->getConnection()->close();
        $connection->setConnection(null);
    }

    private function getConnectionId(WsConnection $connection): int
    {
        return $connection->getConnection()->resourceId;
    }

}