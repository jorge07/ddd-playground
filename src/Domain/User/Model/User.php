<?php

namespace Leos\Domain\User\Model;

use Leos\Domain\User\ValueObject\UserId;
use Leos\Domain\Security\ValueObject\AuthUser;
use Leos\Domain\Security\ValueObject\EncodedPasswordInterface;

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
    private $uuid;

    /**
     * @var string
     */
    private $email;

    /**
     * @var AuthUser
     */
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
     * @param string $username
     * @param string $email
     * @param EncodedPasswordInterface $encodedPassword
     */
    public function __construct(string $username, string $email, EncodedPasswordInterface $encodedPassword)
    {
        $this->uuid = new UserId();
        $this->auth = new AuthUser($username, $encodedPassword);
        $this->email = $email;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return UserId
     */
    public function id(): UserId
    {
        return $this->uuid;
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
