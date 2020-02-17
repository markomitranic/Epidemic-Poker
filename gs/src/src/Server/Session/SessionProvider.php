<?php

namespace App\Server\Session;

use App\Message\SessionChange;
use App\Server\Connection\WsConnection;
use App\Server\Session\IdResolver\Resolver;
use App\Server\Session\IdResolver\UniqidResolver;
use App\Server\Session\Writer\IssueObserver;
use Exception;

class SessionProvider
{

    private IssueObserver $sessionIssueObserver;

    /**
     * @var Resolver[]
     */
    private array $idResolver;

    private Resolver $newSessionIdResolver;

    public function __construct(
        IssueObserver $sessionIssueObserver,
        Resolver ...$idResolvers
    ) {
        $this->sessionIssueObserver = $sessionIssueObserver;
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
                return $resolver->getSessionId($connection);
            } catch (\Throwable $e) {
                continue;
            }
        }

        $sessionId = $this->newSessionIdResolver->getSessionId($connection);
        $this->sessionIssueObserver->handle($connection, $sessionId);

        return $sessionId;
    }

}