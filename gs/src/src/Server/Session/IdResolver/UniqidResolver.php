<?php

namespace App\Server\Session\IdResolver;

use App\Server\Connection\WsConnection;

final class UniqidResolver implements Resolver
{

    public function getSessionId(WsConnection $connection): string
    {
        return uniqid('', true);
    }

}