<?php

namespace App;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class GSServer implements MessageComponentInterface {

    /**
     * @var SplObjectStorage|ConnectionInterface[]
     */
    protected SplObjectStorage $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        Log::info("New connection!", ['client' => $conn->resourceId]);
        $this->clients->attach($conn);

        $conn->send('WELCOME new friend!');
    }

    public function onMessage(ConnectionInterface $from, $msg): void
    {
        Log::info("Incoming message from client.", ['client' => $from, 'message' => $msg]);
        $from->send($msg);
    }

    public function onClose(ConnectionInterface $conn): void
    {
        Log::info("Client left.", ['client' => $conn->resourceId]);
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e): void
    {
        Log::error("Error state.", ['exception' => $e, 'client' => $conn->resourceId]);
        $conn->close();
    }
}