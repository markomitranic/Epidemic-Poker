<?php

namespace App\Server\Session\IdResolver;

use App\Server\Connection\WsConnection;
use Throwable;

interface Resolver
{

    /**
     * @throws Throwable
     */
    public function getSessionId(WsConnection $connection): string;

}