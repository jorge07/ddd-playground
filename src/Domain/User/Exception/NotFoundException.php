<?php

namespace Leos\Domain\User\Exception;

/**
 * Class NotFoundException
 *
 * @package Leos\Domain\User\Exception
 */
class NotFoundException extends \Leos\Domain\Common\Exception\NotFoundException
{
    /**
     * NotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct("user.exception.not_found", 2004);
    }
}
