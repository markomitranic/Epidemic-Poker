<?php

namespace App\Message\Created;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $roomId;

    public function __construct(string $roomId)
    {
        $this->roomId = $roomId;
    }

    public function getRoomId(): string
    {
        return $this->roomId;
    }

    public function jsonSerialize()
    {
        return [
            'roomId' => $this->getRoomId()
        ];
    }
}