<?php

namespace Leos\Domain\User\Event;

use Leos\Domain\Common\Event\AbstractEvent;
use Leos\Domain\User\ValueObject\UserId;

class UserWasCreated extends AbstractEvent
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    public function __construct(UserId $userId, string $username, string $email)
    {
        parent::__construct();
        $this->userId = (string) $userId;
        $this->username = $username;
        $this->email = $email;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }
}
