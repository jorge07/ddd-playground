<?php

namespace Leos\Domain\Security\Exception;


/**
 * Class AuthenticationException
 *
 * @package Leos\Domain\Security\Exception
 */
class AuthenticationException extends \Exception
{
    /**
     * AuthenticationException constructor.
     */
    public function __construct()
    {
        parent::__construct('security.exception.authentication_exception');
    }
}
