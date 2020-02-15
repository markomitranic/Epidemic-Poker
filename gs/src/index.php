<?php

use App\GSServer;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/vendor/autoload.php';

$ws = new WsServer(new GSServer);
$server = IoServer::factory(
    new HttpServer($ws),
    getenv('LISTEN_PORT')
);
$server->run();
