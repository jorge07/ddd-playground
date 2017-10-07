<?php

namespace Leos\Domain\User\Exception;

class UserPasswordsAreNotEquals extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('user.password.not.equals');
    }
}
