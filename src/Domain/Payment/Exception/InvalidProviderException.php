<?php

namespace Leos\Domain\Payment\Exception;

/**
 * Class InvalidProviderException
 *
 * @package Leos\Domain\Payment\Exception
 */
class InvalidProviderException extends \InvalidArgumentException
{
    /**
     * InvalidProviderException constructor.
     */
    public function __construct()
    {
        parent::__construct('payment.exception.invalid_provider', 2200);
    }
}
