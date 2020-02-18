<?php

namespace App\Server;

use App\Message\Handler;
use App\Room\RoomRegistry;

class RoutingTable
{

    /** @var string[] */
    public const ROUTES = [
        \App\Message\Join\Handler::class => 'joinHandler'
    ];

    private RoomRegistry $roomRegistry;

    public function __construct(
        RoomRegistry $roomRegistry
    ) {
        $this->roomRegistry = $roomRegistry;
    }

    public function getHandler(string $handlerName): Handler
    {
        return $this->{self::ROUTES[$handlerName]}();
    }

    private function joinHandler(): Handler
    {
        return new \App\Message\Join\Handler($this->roomRegistry);
    }

}