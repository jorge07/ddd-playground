<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Leos\Domain\Common\ValueObject\AggregateRootId;

class EventAwareId extends AggregateRootId
{
    /** @var string */
    protected $uuid;
}
