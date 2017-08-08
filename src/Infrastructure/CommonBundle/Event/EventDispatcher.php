<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Leos\Domain\Common\Event\EventDispatcherInterface;
use Leos\Domain\Common\Event\EventInterface;
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
    }

    public function dispatch(EventInterface $event): void
    {

        $this->dispatcher->dispatch($this->eventShortName($event), $event);
    }

    public function eventShortName(EventInterface $event): string
    {
        $path = explode('\\', get_class($event));

        return array_pop($path);
    }
}
