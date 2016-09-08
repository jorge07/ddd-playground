<?php

namespace Leos\Application\Request\User;

/**
 * Class RegisterDTO
 * 
 * @package Leos\Application\Request\User
 */
class RegisterDTO
{
    /**
     * @var string
     */
    private $username;
    
    /**
     * @var string
     */
    private $email;
    
    /**
     * @var string
     */
    private $plainPassword;

    /**
     * RegisterDTO constructor.
     *
     * @param string $username
     * @param string $email
     * @param string $plainPassword
     */
    public function __construct(string $username, string $email, string $plainPassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return array
     */
    public function toForm(): array
    {
        return [
            'username' =>   $this->username ?: '',
            'email' =>      $this->email ?: '',
            'password' =>   $this->plainPassword  ?: ''
        ];
    }
}
