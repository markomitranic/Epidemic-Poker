<?php

namespace App\Server\Session;

use App\Server\Connection\WsConnection;
use App\Server\Session\IdResolver\Resolver;
use App\Server\Session\IdResolver\UniqidResolver;
use App\Server\Session\Writer\ExistingSession;
use App\Server\Session\Writer\NewSession;
use App\Utility\Log;
use Exception;

class SessionProvider
{

    /**
     * @var Resolver[]
     */
    private array $idResolver;

    private Resolver $newSessionIdResolver;

    public function __construct(
        Resolver ...$idResolvers
    ) {
        $this->idResolver = $idResolvers;
        $this->newSessionIdResolver = new UniqidResolver();
    }

    /**
     * @throws Exception
     */
    public function getSessionId(WsConnection $connection): string
    {
        foreach ($this->idResolver as $resolver) {
            try {
                $sessionId = $resolver->getSessionId($connection);
                if ($connection->isFreshConnection()) {
                    (new ExistingSession())->handle($connection, $sessionId);
                }
                return $sessionId;
            } catch (\Exception $e) {
                continue;
            } catch (\Throwable $exception) {
                Log::error('Unable to discern the session due to error.', ['exception' => $exception]);
            }
        }

        $sessionId = $this->newSessionIdResolver->getSessionId($connection);
        (new NewSession())->handle($connection, $sessionId);

        return $sessionId;
    }

}