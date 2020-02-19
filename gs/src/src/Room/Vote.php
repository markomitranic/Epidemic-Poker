<?php

namespace App\Room;

use App\Client\Client;

class Vote
{

    private RoomClient $client;

    private float $value;

    public function __construct(RoomClient $client, float $value)
    {
        $this->client = $client;
        $this->value = $value;
    }

    /**
     * @return RoomClient
     */
    public function getClient(): RoomClient
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