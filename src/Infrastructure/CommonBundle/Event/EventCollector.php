<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Leos\Domain\Common\Event\EventInterface;

class EventCollector
{
    private static $instance;

    private $events = [];

    private static function instance(): self
    {
        if (!self::$instance) {

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
        self::instance()->addEvent($event);
    }

    public function flush(): void
    {
        self::instance()->events = [];
    }

    public function events(): array
    {
        return self::instance()->events;
    }
}
