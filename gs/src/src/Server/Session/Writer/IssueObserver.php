<?php

namespace App\Server\Session\Writer;

use App\Server\Connection\WsConnection;

interface IssueObserver
{

    public function handle(WsConnection $connection, string $sessionId): void;

}