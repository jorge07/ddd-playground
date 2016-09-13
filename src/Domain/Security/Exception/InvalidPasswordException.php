<?php

namespace Leos\Domain\Security\Exception;


/**
 * Class InvalidPasswordException
 *
 * @package Leos\Domain\Security\Exception
 */
class InvalidPasswordException extends \Exception
{
    /**
     * InvalidPasswordException constructor.
     */
    public function __construct()
    {
        parent::__construct("security.exception.invalid_password", 6005);
    }
}
