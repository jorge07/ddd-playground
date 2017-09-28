<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Leos\Domain\Common\Event\EventDispatcherInterface;
use Leos\Domain\Common\Event\EventInterface;
use Leos\Domain\Common\Event\EventPublisher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as InfrastructureDispatcher;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var InfrastructureDispatcher
     */
    private $dispatcher;

    /**
     * @var EventCollector
     */
    private $collector;

    public function __construct(InfrastructureDispatcher $dispatcher, EventCollector $collector)
    {
        $this->dispatcher = $dispatcher;

        $this->boot();
        $this->collector = $collector;
    }

    private function boot(): void
    {
        EventPublisher::boot($this);
    }

    public function raise(EventInterface $event): void
    {
        $this->collector->collect($event);
    }

    public function dispatch(): void
    {
        foreach ($this->collector->events() as $event) {

            /** @var EventAware $symfonyEvent */
            $symfonyEvent = new EventAware($event);
            $this->dispatcher->dispatch($symfonyEvent->eventShortName(), $symfonyEvent);
        }

        $this->collector->flush();
    }
}
