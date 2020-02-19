<?php

namespace App\Message\CoffeeBreak;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $roomId;

    private string $clientName;

    public function __construct(string $roomId, string $clientName)
    {
        $this->roomId = $roomId;
        $this->clientName = $clientName;
    }

    public function getRoomId(): string
    {
        return $this->roomId;
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function jsonSerialize()
    {
        return [
            'roomId' => $this->getRoomId(),
            'clientName' => $this->getClientName()
        ];
    }
}