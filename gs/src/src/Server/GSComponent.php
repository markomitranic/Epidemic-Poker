<?php

namespace App\Server;

use App\Server\Connection\WsConnection;
use App\Server\Decorator\Handler;
use App\Utility\Log;
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
            $this->deserializeIncoming($message)
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

    /**
     * @throws \Throwable
     */
    private function deserializeIncoming(string $data): array
    {
        try {
            return json_decode($data, true, 512, JSON_THROW_ON_ERROR);
        }catch (\Throwable $exception) {
            Log::error(
                'Unable to decypher the message. Not json.',
                ['message' => $data, 'exception' => $exception]
            );
            return ['title' => '404', 'payload' => []];
        }
    }
}