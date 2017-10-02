<?php

namespace Leos\Infrastructure\CommonBundle\Event;


use Leos\Domain\Common\Event\EventInterface;
use Leos\Domain\Common\Event\EventStoreInterface;

class EventStore implements EventStoreInterface
{
    private $event;

    private $type;

    private $createdAt;

    public function __construct(EventAware $eventAware)
    {
    }

    public function event(): EventInterface
    {
        // TODO: Implement event() method.
    }

    public function type(): string
    {
        // TODO: Implement type() method.
    }

    public function createdAt(): \DateTimeImmutable
    {
        // TODO: Implement createdAt() method.
    }

}
