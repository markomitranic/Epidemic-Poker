<?php

namespace App\Message\AuthSuccess;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{
    public const TITLE = 'authSuccess';

    public function __construct(string $cookieName)
    {
        parent::__construct(self::TITLE, new Payload($cookieName));
    }
}