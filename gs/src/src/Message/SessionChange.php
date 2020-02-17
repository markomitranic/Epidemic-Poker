<?php

namespace App\Message;

class SessionChange extends Message
{
    public const TITLE = 'sessionChange';

    public function __construct(string $newToken)
    {
        parent::__construct(
            self::TITLE,
            new Payload\SessionChange($newToken)
        );
    }
}