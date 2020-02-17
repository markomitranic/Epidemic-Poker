<?php

namespace App\Server\Session\IdResolver;

use App\Server\Connection\WsConnection;
use App\Utility\ConfigurationProvider;
use Exception;
use function GuzzleHttp\Psr7\parse_header;

final class JwtHeaderResolver implements Resolver
{

    private string $sessionCookieName;

    public function __construct()
    {
        $this->sessionCookieName = self::getSessionCookieName();
    }

    /**
     * @throws Exception
     */
    public function getSessionId(WsConnection $connection): string
    {
        $cookiesHeader = $connection->getRequest()->getHeader('Cookie');
        if(count($cookiesHeader)) {
            $cookies = parse_header($cookiesHeader)[0];
            if (array_key_exists($this->sessionCookieName, $cookies)) {
                return $cookies[$this->sessionCookieName];
            }
        }
        throw new Exception('The request does not provide a valid sessionId');
    }

    private static function getSessionCookieName(): string
    {
        return sprintf(
            'PHPSESSID_%s',
            ConfigurationProvider::get(ConfigurationProvider::SHARD_NAME)
        );
    }

}