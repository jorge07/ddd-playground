<?php

namespace Leos\Domain\Security\ValueObject;

use Leos\Domain\User\ValueObject\UserId;

/**
 * Class AuthUser
 *
 * @package Leos\Domain\Security\Model
 */
final class AuthUser
{
    const DEFAULT_ROLES = [
        'ROLE_USER'
    ];

    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $passwordHash;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * @param string $username
     * @param EncodedPasswordInterface $encodedPassword
     * @param array $roles
     */
    public function __construct(string $username, EncodedPasswordInterface $encodedPassword, array $roles = [])
    {
        $this->username = $username;
        $this->passwordHash = (string) $encodedPassword;
        $this->roles = array_merge(self::DEFAULT_ROLES, $roles);
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
    public function username(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function password(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return array
     */
    public function roles(): array
    {
        return $this->roles;
    }

}
