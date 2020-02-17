<?php

namespace App\Message\SessionChange;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{
    public const TITLE = 'sessionChange';

    public function __construct(string $cookieName, string $newToken)
    {
        parent::__construct(
            self::TITLE,
            new Payload($cookieName, $newToken)
        );
    }
}