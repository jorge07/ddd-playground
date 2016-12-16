<?php

namespace Leos\Application\UseCase\Security\Request;

/**
 * Class Login
 * 
 * @package Leos\Application\UseCase\Security\Request
 */
class Login
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * Login constructor.
     *
     * @param string $username
     * @param string $plainPassword
     */
    public function __construct(string $username, string $plainPassword)
    {
        $this->username = $username;
        $this->plainPassword = $plainPassword;
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
    public function plainPassword(): string
    {
        return $this->plainPassword;
    }
}
