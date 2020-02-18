<?php

namespace App\Server\Session\IdResolver;

use App\Server\Connection\WsConnection;
use App\Server\Session\Writer\NewSession;
use App\Utility\ConfigurationProvider;
use Exception;
use Firebase\JWT\JWT;
use function GuzzleHttp\Psr7\parse_header;

final class JwtHeaderResolver implements Resolver
{

    private string $key;

    private string $sessionCookieName;

    public function __construct()
    {
        $this->key = ConfigurationProvider::get(ConfigurationProvider::JWT_SECRET);
        $this->sessionCookieName = sprintf(
            'PHPSESSID_%s',
            ConfigurationProvider::get(ConfigurationProvider::SHARD_NAME)
        );
    }
    /**
     * @throws Exception
     */
    public function getSessionId(WsConnection $connection): string
    {
        $jwt = $this->findShardCookie($connection);
        $decoded = JWT::decode($jwt, $this->key, [NewSession::ALGO_HS256]);
        return $decoded->sub;
    }

    private function findShardCookie(WsConnection $connection): string {
        $cookiesHeader = $connection->getRequest()->getHeader('Cookie');
        if(count($cookiesHeader)) {
            $cookies = parse_header($cookiesHeader)[0];
            if (array_key_exists($this->sessionCookieName, $cookies)) {
                return $cookies[$this->sessionCookieName];
            }
        }
        throw new Exception('The request does not provide a valid sessionId');
    }

}