<?php

namespace Leos\Domain\Payment\Exception;

/**
 * Class MinWithdrawalAmountException
 *
 * @package Leos\Domain\Payment\Exception
 */
class MinWithdrawalAmountException extends \InvalidArgumentException
{
    /**
     * MinDepositAmountException constructor.
     */
    public function __construct()
    {
        parent::__construct("withdrawal.exception.amount_must_be_higher_than_0", 87000);
    }
}
