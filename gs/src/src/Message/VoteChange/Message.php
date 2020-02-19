<?php

namespace App\Message\VoteChange;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{

    public const TITLE = 'voteChange';

    public function __construct(string $roomId, float $value, string $name)
    {
        parent::__construct(
            self::TITLE,
            new Payload($roomId, $value, $name)
        );
    }

}