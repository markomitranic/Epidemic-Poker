<?php

namespace App\Server\Decorator;

use App\Message\Handler as MessageHandler;
use App\Message\NotFound\Message;
use App\Server\Connection\WsConnection;
use App\Server\RoutingTable;
use Exception;

class Routing extends Decorator
{

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        /** @var MessageHandler $handlerClass */
        foreach (RoutingTable::ROUTES as $handlerClass) {
            if ($handlerClass::shouldHandle($message)) {
                /** @var MessageHandler $handlerInstance */
                $handlerInstance = new $handlerClass();
                $handlerInstance->handle($connection, $message);
                parent::onMessage($connection, $message);
                return $connection;
            }
        }

        $connection->send(new Message());
        return $connection;
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        $connection->getConnection()->close();
        return parent::onError($connection, $exception);
    }

}