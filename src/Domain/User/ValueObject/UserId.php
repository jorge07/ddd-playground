<?php

namespace Leos\Domain\User\ValueObject;

use Leos\Domain\Common\AggregateRootId;

class UserId extends AggregateRootId
{
    /** @var  string */
    protected $uuid;
}
