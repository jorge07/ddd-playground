<?php

namespace Leos\Application\UseCase\User\Request;

use Leos\Domain\User\ValueObject\UserId;

/**
 * Class Register
 * 
 * @package Leos\Application\UseCase\User\Request
 */
class Register
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
     * @var UserId
     */
    private $userId;

    /**
     * Register constructor.
     *
     * @param UserId $userId
     * @param string $username
     * @param string $email
     * @param string $plainPassword
     */
    public function __construct(UserId $userId, string $username, string $email, string $plainPassword)
    {
        $this->username = $username;
        $this->email = $email;
        $this->plainPassword = $plainPassword;
        $this->userId = $userId;
    }

    /**
     * @return array
     */
    public function toForm(): array
    {
        return [
            'uuid' => $this->userId,
            'username' =>   $this->username ?: '',
            'email' =>      $this->email ?: '',
            'password' =>   $this->plainPassword  ?: ''
        ];
    }
}
