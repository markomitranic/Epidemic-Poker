<?php

use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\Server;
use React\Socket\ServerInterface;

require __DIR__ . '/vendor/autoload.php';

final class GSServer {

    private LoopInterface $loop;

    private ServerInterface $socketServer;

    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
        $this->socketServer = new Server('127.0.0.1:8000', $this->loop);
        $this->socketServer->on('connection', [$this, 'handleConnection']);
        $this->loop->run();
    }

    public function handleConnection(ConnectionInterface $connection): void
    {
        $connection->write("Hello " . $connection->getRemoteAddress() . "!\n");
        $connection->write("Welcome to this amazing server!\n");
        $connection->write("Here's a tip: don't say anything.\n");

        $connection->on('data', function ($data) use ($connection) {
            $connection->close();
        });
    }

}

echo sprintf(
    "Welcome to EpidemicPoker.%sSpinning up a WS server on port 8080...%s",
    PHP_EOL,
    PHP_EOL
);

$eventLoop = React\EventLoop\Factory::create();
(new GSServer($eventLoop));