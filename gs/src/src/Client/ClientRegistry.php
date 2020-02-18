<?php

namespace App\Client;

use App\Message\Error;
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

        Log::info(Error::message(Error::NO_CLIENTS_FOUND_FOR_ID), ['sessionId' => $connection->getSessionId()]);
        $this->clients[$connection->getSessionId()] = new Client($connection);
        return $this->clients[$connection->getSessionId()];
    }

}