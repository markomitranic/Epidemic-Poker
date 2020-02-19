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

    private NameGenerator $nameGenerator;

    public function __construct()
    {
        $this->nameGenerator = new NameGenerator();
    }

    public function getOrCreate(WsConnection $connection): Client
    {
        if (array_key_exists($connection->getSessionId(), $this->clients)) {
            return $this->clients[$connection->getSessionId()];
        }

        Log::info(Error::message(Error::NO_CLIENTS_FOUND_FOR_ID), ['sessionId' => $connection->getSessionId()]);
        $this->clients[$connection->getSessionId()] = new Client($connection, $this->getClientName());
        return $this->clients[$connection->getSessionId()];
    }

    private function getClientName(): string
    {
        do {
            $name = $this->nameGenerator->getRandom();
        } while ($this->nameInUse($name));

        return $name;
    }

    private function nameInUse(string $name): bool
    {
        foreach ($this->clients as $client) {
            if ($client->getName() === $name) {
                return true;
            }
        }
        return false;
    }
}