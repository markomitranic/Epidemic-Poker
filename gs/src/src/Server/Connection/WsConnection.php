<?php

namespace App\Server\Connection;

use App\Message\Message;
use Psr\Http\Message\RequestInterface;
use Ratchet\ConnectionInterface;

class WsConnection
{

    private ?ConnectionInterface $connection = null;

    private ?string $sessionId = null;

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

    public function send(Message $message): self
    {
        $this->connection->send(json_encode($message));
        return $this;
    }

    public function close(): void
    {
        $this->connection->close();
    }

}