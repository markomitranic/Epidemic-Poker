<?php

namespace App\Message\VoteChange;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $roomId;

    private float $value;

    private string $name;

    public function __construct(string $roomId, float $value, string $name)
    {
        $this->roomId = $roomId;
        $this->value = $value;
        $this->name = $name;
    }

    public function getRoomId(): string
    {
        return $this->roomId;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function jsonSerialize()
    {
        return [
            'roomId' => $this->getRoomId(),
            'value' => $this->getValue(),
            'name' => $this->getName()
        ];
    }
}