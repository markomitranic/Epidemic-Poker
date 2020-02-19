<?php

namespace App\Message\Leave;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{
    public const TITLE = 'leave';

    public function __construct(string $roomId)
    {
        parent::__construct(
            self::TITLE,
            new Payload($roomId)
        );
    }

}