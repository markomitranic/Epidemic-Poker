<?php

use App\GSServer;
use App\Log;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/vendor/autoload.php';

$publicPort = getenv('LISTEN_PORT');

Log::info("Starting a new GS.", ['publicPort' => $publicPort, 'shardName' => getenv('SHARD_NAME')]);
$ws = new WsServer(new GSServer());
$server = IoServer::factory(new HttpServer($ws), $publicPort);

$server->run();
