<?php

namespace Leos\Domain\Wallet\Exception\Credit;

/**
 * Class CreditNotEnoughException
 *
 * @package Domain\Wallet\Exception\Credit
 */
class CreditNotEnoughException extends \LogicException
{
    /**
     * CreditNotEnoughException constructor.
     */
    public function __construct()
    {
        parent::__construct('credit.exception.not_enough_founds', 4001, null);
    }
}
