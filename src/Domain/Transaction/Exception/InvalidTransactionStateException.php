<?php

namespace Leos\Domain\Transaction\Exception;

/**
 * Class InvalidTransactionStateException
 * 
 * @package Leos\Domain\Transaction\Exception
 */
class InvalidTransactionStateException extends \Exception
{
    /**
     * InvalidTransactionStateException constructor.
     */
    public function __construct()
    {
        parent::__construct("transaction.exception.invalid_state", 9007);
    }
}
