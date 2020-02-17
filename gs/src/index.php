<?php

use App\Server\GSComponent;
use App\Utility\ConfigurationProvider;
use App\Utility\Log;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__ . '/vendor/autoload.php';

$publicPort = ConfigurationProvider::get(ConfigurationProvider::LISTEN_PORT);
$shardName = ConfigurationProvider::get(ConfigurationProvider::SHARD_NAME);
Log::info("Starting a new GS.", ['publicPort' => $publicPort, 'shardName' => $shardName]);

$server = IoServer::factory(
    new HttpServer(new WsServer(
        new GSComponent()
    )),
    $publicPort
);
$server->run();
