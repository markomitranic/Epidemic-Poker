<?php

namespace App\Message\Join;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{
    public const TITLE = 'join';

    public function __construct(string $roomId)
    {
        parent::__construct(
            self::TITLE,
            new Payload($roomId)
        );
    }
}