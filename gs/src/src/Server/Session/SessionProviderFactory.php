<?php

namespace App\Server\Session;

use App\Server\Session\IdResolver\JwtHeaderResolver;
use App\Server\Session\Writer\JwtIssueObserver;

abstract class SessionProviderFactory
{

    public static function get(): SessionProvider
    {
        return new SessionProvider(
            new JwtIssueObserver(),
            ...[
                new JwtHeaderResolver()
            ]
        );
    }

}