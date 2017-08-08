<?php

namespace Leos\Domain\Common\ValueObject;

use Leos\Domain\Common\Event\EventInterface;
use Leos\Domain\Common\Event\EventPublisher;

abstract class AggregateRoot
{

    final protected function raise(EventInterface $event): void
    {
        EventPublisher::dispatch($event);
    }
}
