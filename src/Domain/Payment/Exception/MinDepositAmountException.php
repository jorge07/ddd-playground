<?php

namespace Leos\Domain\Payment\Exception;

/**
 * Class MinDepositAmountException
 *
 * @package Leos\Domain\Payment\Exception
 */
class MinDepositAmountException extends \InvalidArgumentException
{
    /**
     * MinDepositAmountException constructor.
     */
    public function __construct()
    {
        parent::__construct("deposit.exception.amount_must_be_higher_than_0", 77000);
    }
}
