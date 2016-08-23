<?php

namespace Leos\Domain\User\Model;

use Leos\Domain\Security\Model\AuthUser;
use Leos\Domain\User\ValueObject\UserId;

/**
 * Class User
 *
 * @package Leos\Domain\User\Model
 */
class User
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $email;

    private $auth;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var null|\DateTime
     */
    private $updatedAt;

    /**
     * User constructor.
     *
     * @param UserId $userId
     * @param string $email
     * @param AuthUser $auth
     */
    public function __construct(
        UserId $userId,
        string $email,
        AuthUser $auth
    )
    {
        $this->userId = $userId;
        $this->email = $email;
        $this->auth = $auth;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return AuthUser
     */
    public function auth(): AuthUser
    {
        return $this->auth;
    }

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function updatedAt()
    {
        return $this->updatedAt;
    }
}
