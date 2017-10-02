<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Leos\Domain\Common\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

class EventAware extends Event
{
    /**
     * @var EventInterface
     */
    private $event;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    public function __construct(EventInterface $event)
    {
        $this->event = $event;

        $this->createdAt = new \DateTimeImmutable();
    }

    public function eventShortName(): string
    {
        $path = explode('\\', get_class($this->event));

        return array_pop($path);
    }

    public function event(): EventInterface
    {
        return $this->event;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
