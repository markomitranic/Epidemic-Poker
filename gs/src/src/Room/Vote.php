<?php

namespace App\Room;

use App\Client\Client;

class Vote
{

    private Client $client;

    private float $value;

    public function __construct(Client $client, float $value)
    {
        $this->client = $client;
        $this->value = $value;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;
        return $this;
    }

}