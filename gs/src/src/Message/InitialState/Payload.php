<?php

namespace App\Message\InitialState;

use App\Message\Payload as BasePayload;
use App\Room\Round;

class Payload extends BasePayload
{

    private string $roomId;
    private string $clientName;
    private string $type;
    private int $currentRound = 0;
    /**
     * @var Round[]
     */
    private array $results = [];

    public function __construct(
        string $roomId,
        string $clientName,
        string $type,
        int $currentRound,
        array $results
    ) {
        $this->roomId = $roomId;
        $this->clientName = $clientName;
        $this->type = $type;
        $this->currentRound = $currentRound;
        $this->results = $results;
    }

    public function getRoomId(): string
    {
        return $this->roomId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function getCurrentRound(): int
    {
        return $this->currentRound;
    }

    /**
     * @return Round[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'roomId' => $this->getRoomId(),
            'clientName' => $this->getClientName(),
            'type' => $this->getType(),
            'currentRound' => $this->getCurrentRound(),
            'results' => $this->serializeResults()
        ];
    }

    private function serializeResults(): array
    {
        $rounds = [];
        foreach ($this->results as $round) {
            $rounds[] = $this->serializeVotes($round);
        }
        return $rounds;
    }

    private function serializeVotes(Round $round): array
    {
        $results = [];
        foreach ($round->getVotes() as $vote) {
            $results[] = [
                'name' => $vote->getClient()->getName(),
                'value' => $vote->getValue()
            ];
        }
        return $results;
    }
}