<?php

namespace App\Message\InitialState;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{

    public const TITLE = 'initialState';

    public function __construct(string $roomId)
    {
        parent::__construct(
            self::TITLE,
            new Payload($roomId)
        );
    }

}