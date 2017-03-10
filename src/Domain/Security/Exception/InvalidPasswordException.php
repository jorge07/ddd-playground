<?php

namespace Leos\Domain\Security\Exception;

/**
 * Class InvalidPasswordException
 *
 * @package Leos\Domain\Security\Exception
 */
class InvalidPasswordException extends \InvalidArgumentException
{
    /**
     * InvalidPasswordException constructor.
     */
    public function __construct()
    {
        parent::__construct("security.exception.invalid_password", 6005);
    }
}
