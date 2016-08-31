<?php

namespace Leos\Domain\Transaction\Exception;

/**
 * Class TransactionNotFoundException
 *
 * @package Leos\Domain\Transaction\Exception
 */
class TransactionNotFoundException extends \Exception
{

    /**
     * TransactionNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('transaction.exception.not_found', 6004);
    }
}
