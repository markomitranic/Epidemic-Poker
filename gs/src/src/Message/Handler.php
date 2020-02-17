<?php

namespace App\Message;

use App\Server\Connection\WsConnection;

interface Handler
{

    public function handle(WsConnection $connection, array $data): void;

    public static function shouldHandle(array $data): bool;

}