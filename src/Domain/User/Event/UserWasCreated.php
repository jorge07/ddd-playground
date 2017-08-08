<?php

namespace Leos\Domain\User\Event;

use Leos\Domain\Common\Event\EventInterface;
use Leos\Domain\User\ValueObject\UserId;

class UserWasCreated implements EventInterface
{
    /**
     * @var UserId
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
        $this->userId = $userId;
        $this->username = $username;
        $this->email = $email;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
