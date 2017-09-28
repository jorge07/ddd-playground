<?php

namespace Leos\Infrastructure\CommonBundle\Bus\Middleware;

use League\Tactician\Middleware;
use Leos\Domain\Common\Event\EventDispatcherInterface;

class EventDispatcherMiddleware implements Middleware
{

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $this->eventDispatcher->dispatch();

        return $returnValue;
    }
}