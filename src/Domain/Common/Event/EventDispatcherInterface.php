<?php

namespace Leos\Domain\Common\Event;


interface EventDispatcherInterface
{

    public function dispatch(EventInterface $event): void;
}
