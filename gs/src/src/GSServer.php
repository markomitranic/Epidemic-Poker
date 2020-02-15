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
        echo "New connection! ({$conn->resourceId})" . PHP_EOL;
        $this->clients->attach($conn);
        $conn->send('WELCOME new friend!');
    }

    public function onMessage(ConnectionInterface $from, $msg): void
    {
        echo "Client says: $msg" . PHP_EOL;
        $from->send($msg);
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->clients->detach($conn);
        echo "Client left.";
    }

    public function onError(ConnectionInterface $conn, \Exception $e): void
    {
        printf($e);
        $conn->close();
    }
}