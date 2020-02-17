<?php

namespace App\Message\NotFound;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    public function jsonSerialize()
    {
        return [
            'error' => '404 Action cannot be resolved.'
        ];
    }
}