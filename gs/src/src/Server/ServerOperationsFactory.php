<?php

namespace App\Server;

use App\Client\ClientRegistry;
use App\Server\Connection\WsConnectionRegistry;
use App\Server\Decorator\Handler;
use App\Server\Decorator\Log;
use App\Server\Decorator\Routing;
use App\Server\Decorator\Session;
use App\Server\Session\SessionProviderFactory;

abstract class ServerOperationsFactory
{

    public static function getServerOperations(): Handler
    {
        $serverOperations = new Log();
        $serverOperations = new Routing($serverOperations, new ClientRegistry());
        $serverOperations = new Session($serverOperations, SessionProviderFactory::get(), new WsConnectionRegistry());
        return $serverOperations;
    }

}