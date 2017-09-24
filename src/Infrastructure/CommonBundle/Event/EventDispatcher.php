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

    public function __construct(InfrastructureDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;

        $this->boot();
    }

    private function boot(): void
    {
        EventPublisher::boot($this);
    }

    public function dispatch(EventInterface $event): void
    {
        /** @var EventAware $symfonyEvent */
        $symfonyEvent = new EventAware($event);

        $this->dispatcher->dispatch($symfonyEvent->eventShortName(), $symfonyEvent);
    }

}
