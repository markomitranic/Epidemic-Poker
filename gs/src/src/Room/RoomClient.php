<?php

namespace App\Room;

use App\Client\Client;

class RoomClient
{

    private Client $client;

    private string $name;

    public function __construct(Client $client, string $name)
    {
        $this->client = $client;
        $this->name = $name;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getName(): string
    {
        return $this->name;
    }

}