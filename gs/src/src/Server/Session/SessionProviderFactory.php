<?php

namespace App\Server\Session;

use App\Server\Session\IdResolver\JwtHeaderResolver;

abstract class SessionProviderFactory
{

    public static function get(): SessionProvider
    {
        return new SessionProvider(...[
            new JwtHeaderResolver()
        ]);
    }

}