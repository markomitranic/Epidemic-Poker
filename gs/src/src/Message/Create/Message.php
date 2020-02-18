<?php

namespace App\Message\Create;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{
    public const TITLE = 'create';

    public function __construct(string $type)
    {
        parent::__construct(
            self::TITLE,
            new Payload($type)
        );
    }

}