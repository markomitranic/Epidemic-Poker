<?php

namespace App\Message\AuthSuccess;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $cookieName;

    public function __construct(string $cookieName)
    {
        $this->cookieName = $cookieName;
    }

    public function getCookieName(): string
    {
        return $this->cookieName;
    }

    public function jsonSerialize()
    {
        return [
            'cookieName' => $this->getCookieName()
        ];
    }
}