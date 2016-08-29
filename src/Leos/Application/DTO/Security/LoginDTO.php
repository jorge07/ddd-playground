<?php

namespace Leos\Application\DTO\Security;

/**
 * Class LoginDTO
 *
 * @package Leos\Application\DTO\Security
 */
class LoginDTO
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
     * LoginDTO constructor.
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
