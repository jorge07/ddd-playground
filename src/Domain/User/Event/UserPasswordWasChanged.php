<?php

namespace Leos\Domain\User\Event;

use Leos\Domain\Common\Event\AbstractEvent;
use Leos\Domain\User\ValueObject\UserId;

class UserPasswordWasChanged extends AbstractEvent
{
    /**
     * @var string
     */
    private $userId;

    public function __construct(UserId $userId)
    {
        parent::__construct();
        $this->userId = (string) $userId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
