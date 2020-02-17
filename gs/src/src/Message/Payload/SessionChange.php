<?php

namespace App\Message\Payload;

class SessionChange extends Payload
{

    private string $token;

    public function __construct(string $newSessionToken)
    {
        $this->token = $newSessionToken;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function jsonSerialize()
    {
        return [
            'token' => $this->getToken()
        ];
    }
}