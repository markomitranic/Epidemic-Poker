<?php

namespace App\Message;

use App\Utility\Log;

abstract class Error
{

    public const SERVER_ERROR = 500;
    public const NOT_FOUND = 1582037581;
    public const PAYLOAD_DESERIALIZE = 1582037320;
    public const NO_ROOM = 1582038750;

    /** @var int[] */
    private const MESSAGES = [
        self::SERVER_ERROR => 'Unknown error',
        self::NOT_FOUND => 'Resource not found.',
        self::PAYLOAD_DESERIALIZE => 'Unable to deserialize the payload',
        self::NO_ROOM => 'Room with that name cannot be found.'
    ];

    public static function message($code): string
    {
        try {
            return self::MESSAGES[$code];
        } catch (\Throwable $exception) {
            Log::error('An invalid error code was provided.', ['code' => $code, 'exception' => $exception]);
        }

        return self::MESSAGES[self::SERVER_ERROR];
    }

}