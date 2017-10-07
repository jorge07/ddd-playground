<?php

namespace Leos\Infrastructure\CommonBundle\Bus\Middleware;

use League\Tactician\Middleware;
use Leos\Domain\Common\Event\EventCollector;
use Leos\Infrastructure\CommonBundle\Event\EventAware;
use Leos\Infrastructure\CommonBundle\Repository\EventStoreRepository;

class EventStoreMiddleware implements Middleware
{
    /**
     * @var EventStoreRepository
     */
    private $eventStoreRepository;

    /**
     * @var EventCollector
     */
    private $eventCollector;

    public function __construct(EventStoreRepository $eventStoreRepository, EventCollector $eventCollector)
    {
        $this->eventStoreRepository = $eventStoreRepository;
        $this->eventCollector = $eventCollector;
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $events = $this->eventCollector->events();

        foreach ($events as $event) {

            $symfonyEvent = new EventAware($event);
            $this->eventStoreRepository->store($symfonyEvent);
        }

        return $returnValue;
    }
}