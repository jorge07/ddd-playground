<?php

namespace Leos\Domain\Security\Model;

use Leos\Domain\User\Model\User;

/**
 * Class AuthUser
 *
 * @package Leos\Domain\Security\Model
 */
class AuthUser
{
    /**
     * @var string
     */
    protected $username;

    /**
     * @var null|string
     */
    protected $plainPassword = null;

    /**
     * @var
     */
    protected $passwordHash;

    /**
     * @var array
     */
    protected $roles = [];

    /**
     * AuthUser constructor.
     *
     * @param string $username
     * @param string $plainPassword
     * @param array $roles
     */
    public function __construct(string $username, string $plainPassword, array $roles = [])
    {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return null|string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->passwordHash;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }



}
