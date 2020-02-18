<?php

namespace App\Server\Decorator;

use App\Server\Connection\WsConnection;
use App\Server\Connection\WsConnectionRegistry;
use Exception;

final class Connection extends Decorator
{

    private WsConnectionRegistry $connectionRegistry;

    public function __construct(
        Handler $handler,
        WsConnectionRegistry $connectionRegistry
    ) {
        $this->connectionRegistry = $connectionRegistry;
        parent::__construct($handler);
    }

    public function onOpen(WsConnection $connection): WsConnection
    {
        try {
            return parent::onOpen($this->connectionRegistry->get($connection));
        } catch (\Exception $e) {
            return parent::onOpen($this->connectionRegistry->create($connection));
        }
    }

    public function onMessage(WsConnection $connection, array $message): WsConnection
    {
        try {
            return parent::onMessage($this->connectionRegistry->get($connection), $message);
        } catch (\Exception $e) {
            return parent::onOpen($this->connectionRegistry->create($connection));
        }
    }

    public function onError(WsConnection $connection, Exception $exception): WsConnection
    {
        $this->connectionRegistry->close($connection);
        return parent::onError($connection, $exception);
    }

    public function onClose(WsConnection $connection): WsConnection
    {
        $this->connectionRegistry->close($connection);
        return parent::onClose($connection);
    }

}