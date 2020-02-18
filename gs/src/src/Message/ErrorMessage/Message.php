<?php

namespace App\Message\ErrorMessage;

use App\Message\Error;
use App\Message\Message as BaseMessage;

class Message extends BaseMessage
{

    /** @var string  */
    public const TITLE = 'error';

    public function __construct(
        array $originalMessage,
        int $errorCode = Error::NOT_FOUND,
        string $errorMessage = null
    ) {
        if (is_null($errorMessage)) {
            $errorMessage = Error::message($errorCode);
        }

        parent::__construct(
            self::TITLE,
            new Payload($originalMessage, $errorMessage, $errorCode)
        );
    }

}