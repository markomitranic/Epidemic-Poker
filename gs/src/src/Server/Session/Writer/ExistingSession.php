<?php

namespace App\Server\Session\Writer;

use App\Message\AuthSuccess\Message;
use App\Utility\ConfigurationProvider;
use App\Server\Connection\WsConnection;

class ExistingSession implements IssueObserver
{

    private string $shardName;

    private string $sessionCookieName;

    public function __construct()
    {
        $this->shardName = ConfigurationProvider::get(ConfigurationProvider::SHARD_NAME);
        $this->sessionCookieName = sprintf('PHPSESSID_%s', $this->shardName);
    }

    public function handle(WsConnection $connection, string $sessionId): void
    {
        $connection->send(new Message($this->sessionCookieName));
    }

}