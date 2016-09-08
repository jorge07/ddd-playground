<?php

namespace Leos\Domain\Security\Exception;

/**
 * Class NullPasswordException
 *
 * @package Leos\Domain\Security\Exception
 */
class NullPasswordException extends \Exception
{
    /**
     * NullPasswordException constructor.
     */
    public function __construct()
    {
        parent::__construct("security.exception.null_password", 6006);
    }
}
