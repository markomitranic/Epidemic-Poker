<?php

namespace App\Room;

use App\Client\Client;

class Room
{

    private string $name;

    /**
     * @var Client[]
     */
    private array $clients;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function join(Client $client): void
    {
        $this->clients[$client->getId()] = $client;
    }

}