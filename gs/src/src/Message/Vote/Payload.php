<?php

namespace App\Message\Vote;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $roomId;

    private float $value;

    public function __construct(string $roomId, float $value)
    {
        $this->roomId = $roomId;
        $this->value = $value;
    }

    public function getRoomId(): string
    {
        return $this->roomId;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return [
            'roomId' => $this->getRoomId(),
            'value' => $this->getValue()
        ];
    }
}