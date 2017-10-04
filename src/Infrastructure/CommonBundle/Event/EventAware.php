<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Leos\Domain\Common\Event\EventInterface;
use Symfony\Component\EventDispatcher\Event;

class EventAware extends Event
{
    /**
     * @var EventAwareId
     */
    private $uuid;

    /**
     * @var EventInterface
     */
    private $event;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    /**
     * @var string
     */
    private $type;

    public function __construct(EventInterface $event)
    {
        $this->uuid = new EventAwareId();
        $this->event = $event;

        $this->setType();
        $this->createdAt = new \DateTimeImmutable();
    }

    private function setType(): void
    {
        $path = explode('\\', get_class($this->event));

        $this->type = array_pop($path);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function uuid(): EventAwareId
    {
        return $this->uuid;
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
