<?php

namespace App\Server\Session\Writer;

use App\Message\SessionChange\Message;
use App\Utility\ConfigurationProvider;
use DateTimeImmutable;
use \Firebase\JWT\JWT;
use App\Server\Connection\WsConnection;

class NewSession implements IssueObserver
{

    /** @var string  */
    public const ALGO_HS256 = 'HS256';

    private string $key;

    private string $shardName;

    private string $sessionCookieName;

    public function __construct()
    {
        $this->key = ConfigurationProvider::get(ConfigurationProvider::JWT_SECRET);
        $this->shardName = ConfigurationProvider::get(ConfigurationProvider::SHARD_NAME);
        $this->sessionCookieName = sprintf('PHPSESSID_%s', $this->shardName);
    }

    public function handle(WsConnection $connection, string $sessionId): void
    {
        $token = JWT::encode(
            [
                "iss" => $this->shardName,
                "aud" => $this->shardName,
                "sub" => $sessionId,
                "exp" => (new DateTimeImmutable())->modify("+1 day")->format('U')
            ],
            $this->key
        );

        $connection->send(new Message($this->sessionCookieName, $token));
    }

}