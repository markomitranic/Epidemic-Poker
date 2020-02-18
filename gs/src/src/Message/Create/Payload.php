<?php

namespace App\Message\Create;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function jsonSerialize()
    {
        return [
            'roomId' => $this->getType()
        ];
    }
}