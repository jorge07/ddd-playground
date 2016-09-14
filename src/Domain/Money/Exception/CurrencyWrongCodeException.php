<?php

namespace Leos\Domain\Money\Exception;

/**
 * Class CurrencyWrongCodeException
 *
 * @package Leos\Domain\Money\Exception
 */
class CurrencyWrongCodeException extends \InvalidArgumentException
{
    /**
     * CreditNotEnoughException constructor.
     */
    public function __construct()
    {
        parent::__construct('currency.exception.wrong_code', 5001, null);
    }
}
