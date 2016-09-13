<?php

namespace Leos\Domain\Deposit\Exception;

/**
 * Class MinDepositAmountException
 *
 * @package Leos\Domain\Deposit\Exception
 */
class MinDepositAmountException extends \Exception
{
    /**
     * MinDepositAmountException constructor.
     */
    public function __construct()
    {
        parent::__construct("deposit.exception.amount_must_be_higher_than_0", 77000);
    }
}
