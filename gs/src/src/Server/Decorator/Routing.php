<?php

namespace App\Server\Decorator;

use App\Message\Handler as MessageHandler;
use App\Message\NotFound\Message;
use App\Server\Connection\WsConnection;
use Exception;

class Routing extends Decorator
{

    /**
     * @var MessageHandler[]
     */
    private array $handlers;

    public function __construct(
        Handler $handler,
        MessageHandler ...$messageHandlers
    ) {
        $this->handlers = $messageHandlers;
        parent::__construct($handler);
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        foreach ($this->handlers as $handler) {
            if ($handler::shouldHandle($message)) {
                $handler->handle($connection, $message);
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