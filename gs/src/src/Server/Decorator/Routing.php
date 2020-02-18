<?php

namespace App\Server\Decorator;

use App\Message\Handler as MessageHandler;
use App\Message\ErrorMessage\Message as NotFoundMessage;
use App\Server\Connection\WsConnection;
use App\Server\RoutingTable;
use Exception;

class Routing extends Decorator
{

    private RoutingTable $routingTable;

    public function __construct(Handler $handler, RoutingTable $routingTable)
    {
        $this->routingTable = $routingTable;
        parent::__construct($handler);
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        /** @var MessageHandler $handlerClass */
        foreach (RoutingTable::ROUTES as $handlerClass => $value) {
            if ($handlerClass::shouldHandle($message)) {
                $handlerInstance = $this->routingTable->getHandler($handlerClass);
                $handlerInstance->handle($connection, $message);
                parent::onMessage($connection, $message);
                return $connection;
            }
        }

        $connection->send(new NotFoundMessage($message, ));
        return parent::onMessage($connection, $message);
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        $connection->getConnection()->close();
        return parent::onError($connection, $exception);
    }

}