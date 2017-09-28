<?php

namespace Leos\Domain\Common\Event;


interface EventDispatcherInterface
{
    public function raise(EventInterface $event): void;

    public function dispatch(): void;
}
