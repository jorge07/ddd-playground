<?php

namespace Leos\Domain\Common\Event;

final class EventPublisher
{
    /** @var self */
    private static $instance;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    private function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public static function boot(EventDispatcherInterface $dispatcher): void
    {
        if (!static::$instance) {

            static::$instance = new self($dispatcher);
        }
    }

    public static function raise(EventInterface $event): void
    {
        if (!static::$instance) {

            throw new \LogicException('EventPublisher needs to be booted before invoke raise.');
        }

        static::$instance->dispatcher->record($event);
    }
}
