<?php

namespace App\Message\Join;

use App\Server\Connection\WsConnection;
use App\Utility\Log;

class Handler implements \App\Message\Handler
{

    /** @var string  */
    public const NAME = 'join';

    public function handle(WsConnection $connection, array $data): void
    {
        Log::info('GOT A JOIN HERE!');
    }

    public static function shouldHandle(array $data): bool
    {
        if (array_key_exists('title', $data) && $data['title'] === self::NAME) {
            return true;
        }
        return false;
    }
}