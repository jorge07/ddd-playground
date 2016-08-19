<?php

namespace Leos\Domain\Transaction\Exception;

/**
 * Class InvalidTransactionTypeException
 * 
 * @package Leos\Domain\Transaction\Exception
 */
class InvalidTransactionTypeException extends \LogicException
{
    /**
     * InvalidTransactionTypeException constructor.
     */
    public function __construct()
    {
        parent::__construct("transaction.exception.invalid_type", 9006);
    }
}
