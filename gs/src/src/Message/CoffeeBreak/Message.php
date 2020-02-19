<?php

namespace App\Message\CoffeeBreak;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{

    public const TITLE = 'coffeeBreak';

    public function __construct(string $roomId, string $clientName)
    {
        parent::__construct(
            self::TITLE,
            new Payload($roomId, $clientName)
        );
    }

}