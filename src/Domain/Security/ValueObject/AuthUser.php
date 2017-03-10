<?php

namespace Leos\Domain\Security\ValueObject;

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

    public function __construct(string $username, EncodedPasswordInterface $encodedPassword, array $roles = [])
    {
        $this->username = $username;
        $this->passwordHash = (string) $encodedPassword;
        $this->roles = array_merge(self::DEFAULT_ROLES, $roles);
    }

    public function username(): string
    {
        return $this->username;
    }

    public function password(): string
    {
        return $this->passwordHash;
    }

    public function roles(): array
    {
        return $this->roles;
    }

}
