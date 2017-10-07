<?php

namespace Leos\Domain\Common\Event;

abstract class AbstractEvent implements EventInterface
{
    /**
     * @var EventId
     */
    private $uuid;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTimeImmutable
     */
    private $createdAt;

    public function __construct()
    {
        $this->uuid = new EventId();

        $this->setType();
        $this->createdAt = new \DateTimeImmutable();
    }

    private function setType(): void
    {
        $path = explode('\\', get_class($this));

        $this->type = array_pop($path);
    }

    public function type(): string
    {
        return $this->type;
    }

    public function uuid(): EventId
    {
        return $this->uuid;
    }

    public function createdAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}
