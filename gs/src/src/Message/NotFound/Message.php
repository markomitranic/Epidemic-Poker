<?php

namespace App\Message\NotFound;

use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{
    public const TITLE = '404';

    public function __construct()
    {
        parent::__construct(self::TITLE, new Payload());
    }
}