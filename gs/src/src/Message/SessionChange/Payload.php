<?php

namespace App\Message\SessionChange;

use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private string $cookieName;

    private string $token;

    public function __construct(string $cookieName, string $newSessionToken)
    {
        $this->cookieName = $cookieName;
        $this->token = $newSessionToken;
    }

    public function getCookieName(): string
    {
        return $this->cookieName;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function jsonSerialize()
    {
        return [
            'cookieName' => $this->getCookieName(),
            'token' => $this->getToken()
        ];
    }
}