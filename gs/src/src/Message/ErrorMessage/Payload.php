<?php

namespace App\Message\ErrorMessage;

use App\Message\Error;
use App\Message\Message as BaseMessage;
use App\Message\Payload as BasePayload;

class Payload extends BasePayload
{

    private array $originalMessage;
    private string $errorMessage;
    private int $errorCode;

    public function __construct(array $originalMessage, string $errorMessage, int $errorCode = 0)
    {
        $this->originalMessage = $originalMessage;
        $this->errorMessage = $errorMessage;
        $this->errorCode = $errorCode;
    }

    public function jsonSerialize()
    {
        return [
            'originalMessage' => $this->originalMessage,
            'errorMessage' => $this->errorMessage,
            'errorCode' => $this->errorCode
        ];
    }
}