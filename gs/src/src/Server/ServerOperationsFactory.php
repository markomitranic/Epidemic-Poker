<?php

namespace App\Server;

use App\Client\ClientRegistry;
use App\Room\RoomRegistry;
use App\Server\Connection\WsConnectionRegistry;
use App\Server\Decorator\BaseHandler;
use App\Server\Decorator\Client;
use App\Server\Decorator\Connection;
use App\Server\Decorator\Handler;
use App\Server\Decorator\Log;
use App\Server\Decorator\Routing;
use App\Server\Decorator\Session;
use App\Server\Session\SessionProviderFactory;

class ServerOperationsFactory
{

    private RoomRegistry $roomRegistry;
    private ClientRegistry $clientRegistry;
    private WsConnectionRegistry $connectionRegistry;

    public function __construct()
    {
        $this->roomRegistry = new RoomRegistry();
        $this->clientRegistry = new ClientRegistry();
        $this->connectionRegistry = new WsConnectionRegistry();
        $this->routingTable = new RoutingTable($this->roomRegistry);
    }

    public function getServerOperations(): Handler
    {
        $serverOperations = new BaseHandler();
        $serverOperations = new Routing($serverOperations, $this->routingTable);
        $serverOperations = new Client($serverOperations, $this->clientRegistry);
        $serverOperations = new Session($serverOperations, SessionProviderFactory::get());
        $serverOperations = new Connection($serverOperations, $this->connectionRegistry);
        $serverOperations = new Log($serverOperations);
        return $serverOperations;
    }

}