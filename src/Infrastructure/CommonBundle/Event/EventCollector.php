<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Leos\Domain\Common\Event\EventInterface;

class EventCollector
{
    /**
     * @var static
     */
    private static $instance;

    /**
     * @var EventInterface[]
     */
    private $events = [];

    private function __construct()
    {
    }

    private static function instance(): self
    {
        if (null === self::$instance) {

            self::$instance = new self();
        }

        return self::$instance;
    }

    private function addEvent(EventInterface $event): void
    {
        $this->events[] = $event;
    }

    public function collect(EventInterface $event): void
    {
        $this->addEvent($event);
    }

    public function flush(): void
    {
        $this->events = [];
    }

    public function events(): array
    {
        return self::instance()->events;
    }

    public function remove(int $key): void
    {
        if (true === array_key_exists($key, $this->events)) {

            unset($this->events[$key]);
        }
    }
}
