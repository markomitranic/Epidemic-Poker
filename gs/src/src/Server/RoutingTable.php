<?php

namespace App\Server;

class RoutingTable
{

    /** @var string[] */
    public const ROUTES = [
        \App\Message\Join\Handler::class
    ];

}