<?php

namespace Leos\Domain\Common\Event;

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

    public static function instance(): self
    {
        if (null === self::$instance) {

            self::$instance = new self();
        }

        return self::$instance;
    }

    private function addEvent(EventInterface $event): void
    {
        self::instance()->events[] = $event;
    }

    public function collect(EventInterface $event): void
    {
        $this->addEvent($event);
    }

    public function flush(): void
    {
        self::instance()->events = [];

        reset(self::instance()->events);
    }

    /**
     * @return EventInterface[]
     */
    public function events(): array
    {
        return self::instance()->events;
    }

    public function remove(int $key): void
    {
        if (true === array_key_exists($key, self::instance()->events)) {

            unset(self::instance()->events[$key]);
        }
    }

    public function shutdown()
    {
        self::$instance = null;
    }
}
