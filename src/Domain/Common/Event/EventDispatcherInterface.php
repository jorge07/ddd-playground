<?php

namespace Leos\Domain\Common\Event;


interface EventDispatcherInterface
{
    public function record(EventInterface $event): void;

    public function dispatch(): void;
}
