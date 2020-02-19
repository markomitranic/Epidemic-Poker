<?php

namespace App\Room;

use App\Client\Client;

class Room
{

    private string $name;

    private string $type = 'float';

    /**
     * @var Client[]
     */
    private array $clients;

    private int $currentRound = 0;

    /**
     * @var Round[]
     */
    private array $rounds = [];

    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
        $this->rounds[] = new Round();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function join(Client $client): void
    {
        $this->clients[$client->getId()] = $client;
    }

    /**
     * @return Client[]
     */
    public function getClients(): array
    {
        return $this->clients;
    }

    public function getCurrentRoundIndex(): int
    {
        return $this->currentRound;
    }

    public function getCurrentRound(): Round
    {
        return $this->getRounds()[$this->getCurrentRoundIndex()];
    }

    /**
     * @return Round[]
     */
    public function getRounds(): array
    {
        return $this->rounds;
    }


}