<?php

namespace App\Message\Vote;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{

    public const TITLE = 'vote';

    public function __construct(string $roomId, float $value)
    {
        parent::__construct(
            self::TITLE,
            new Payload($roomId, $value)
        );
    }

}