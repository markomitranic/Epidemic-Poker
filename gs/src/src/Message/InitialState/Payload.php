<?php

namespace App\Message\InitialState;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $roomId;

    public function __construct(
        string $roomId
    ) {
        $this->roomId = $roomId;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'roomId' => $this->roomId
        ];
    }
}