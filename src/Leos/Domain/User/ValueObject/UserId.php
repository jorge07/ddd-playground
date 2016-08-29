<?php

namespace Leos\Domain\User\ValueObject;

use Leos\Domain\Common\ValueObject\AggregateRootId;

/**
 * Class UserId
 *
 * @package Leos\Domain\User\ValueObject
 */
class UserId extends AggregateRootId
{
    /** @var  string */
    protected $uuid;
}
