<?php

namespace App\Server\Connection;

use App\Client\Client;
use App\Message\Message;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;

class WsConnection
{

    private ?ConnectionInterface $connection = null;

    private ?string $sessionId = null;

    private ?Client $client = null;

    private bool $freshConnection = true;

    public function getConnection(): ?ConnectionInterface
    {
        return $this->connection;
    }

    public function setConnection(?ConnectionInterface $connection): self
    {
        $this->connection = $connection;
        return $this;
    }

    public function getRequest(): ?RequestInterface
    {
        if (isset($this->connection) && !is_null($this->connection)) {
            return $this->connection->httpRequest;
        }

        return null;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function isFreshConnection(): bool
    {
        return $this->freshConnection;
    }

    public function setFreshConnection(bool $isFresh): self
    {
        $this->freshConnection = $isFresh;
        return $this;
    }

    public function send(Message $message): self
    {
        $this->connection->send(json_encode($message));
        return $this;
    }

}