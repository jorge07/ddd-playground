<?php

namespace Leos\Domain\User\Exception;

use Leos\Domain\Common\Exception\NotFoundException;

/**
 * Class UserNotFoundException
 *
 * @package Leos\Domain\User\Exception
 */
class UserNotFoundException extends NotFoundException
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct("user.exception.not_found", 2004);
    }
}
