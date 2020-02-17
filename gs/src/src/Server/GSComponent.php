<?php

namespace App\Server;

use App\Server\Connection\WsConnection;
use App\Server\Decorator\Handler;
use Exception;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class GSComponent implements MessageComponentInterface {

    private Handler $serverOperations;

    public function __construct() {
        $this->serverOperations = ServerOperationsFactory::getServerOperations();
    }

    public function onOpen(ConnectionInterface $connection): void
    {
        $this->serverOperations->onOpen(
            $this->createTransientConnection($connection),
        );
    }

    public function onMessage(ConnectionInterface $connection, $message): void
    {
        $this->serverOperations->onMessage(
            $this->createTransientConnection($connection),
            $message
        );
    }

    public function onClose(ConnectionInterface $connection): void
    {
        $this->serverOperations->onClose(
            $this->createTransientConnection($connection),
        );
    }

    public function onError(ConnectionInterface $connection, Exception $exception): void
    {
        $this->serverOperations->onError(
            $this->createTransientConnection($connection),
            $exception
        );
    }

    private function createTransientConnection(ConnectionInterface $connection): WsConnection
    {
        $wsConnection = new WsConnection();
        $wsConnection->setConnection($connection);
        return $wsConnection;
    }
}