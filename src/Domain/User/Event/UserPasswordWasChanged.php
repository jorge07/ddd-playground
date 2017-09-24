<?php

namespace Leos\Domain\User\Event;

use Leos\Domain\Common\Event\EventInterface;
use Leos\Domain\Common\ValueObject\AggregateRootId;

class UserPasswordWasChanged implements EventInterface
{
    /**
     * @var AggregateRootId
     */
    private $userId;

    public function __construct(AggregateRootId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): AggregateRootId
    {
        return $this->userId;
    }
}
