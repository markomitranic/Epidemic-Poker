<?php

namespace App\Client;

use App\Server\Connection\WsConnection;

class Client
{

    private string $id;

    private ?WsConnection $connection;

    public function __construct(WsConnection $connection) {
        $this->id = $connection->getSessionId();
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function getConnection(): ?WsConnection
    {
        return $this->connection;
    }

    public function setConnection(?WsConnection $connection): self
    {
        $this->connection = $connection;
        return $this;
    }

}