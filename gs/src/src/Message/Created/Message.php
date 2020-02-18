<?php

namespace App\Message\Created;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{
    public const TITLE = 'created';

    public function __construct(string $roomId)
    {
        parent::__construct(
            self::TITLE,
            new Payload($roomId)
        );
    }

}