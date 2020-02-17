<?php

namespace App\Client;

use App\Server\Connection\WsConnection;
use App\Utility\Log;

class ClientRegistry
{

    /**
     * @var Client[]
     */
    private array $clients = [];

    public function getOrCreate(WsConnection $connection): Client
    {
        if (array_key_exists($connection->getSessionId(), $this->clients)) {
            return $this->clients[$connection->getSessionId()];
        }

        Log::error('No clients found for that id.', ['sessionId' => $connection->getSessionId()]);
        $this->clients[$connection->getSessionId()] = new Client($connection);
        return $this->clients[$connection->getSessionId()];
    }

}