<?php

namespace App\Room;

use App\Client\Client;
use App\Client\NameGenerator;

class Room
{

    const CLIENTS_LIMIT = 10;

    private string $name;

    private string $type = 'float';

    /**
     * @var RoomClient[]
     */
    private array $clients = [];

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

    /**
     * @param Client $client
     * @return RoomClient
     * @throws \Exception
     */
    public function join(Client $client): RoomClient
    {
        try {
            return $this->findClient($client);
        } catch (\Exception $e) {
            $roomClient = new RoomClient($client, $this->getUniqueClientName());
            $this->clients[$client->getId()] = $roomClient;
            return $roomClient;
        }
    }

    public function leave(RoomClient $client): void
    {
        unset($this->clients[$client->getClient()->getId()]);
    }

    /**
     * @param Client $client
     * @return RoomClient
     * @throws \Exception
     */
    public function findClient(Client $client): RoomClient
    {
        if (array_key_exists($client->getId(), $this->clients)) {
            return $this->clients[$client->getId()];
        }
        throw new \Exception('The client cannot be found');
    }

    /**
     * @return RoomClient[]
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

    /**
     * @return string
     * @throws \Exception
     */
    private function getUniqueClientName(): string
    {
        $retries = self::CLIENTS_LIMIT;
        do {
            $name = NameGenerator::getRandom();
            $retries--;
            if ($retries <= 0) {
                throw new \Exception('Room is currently full.');
            }
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