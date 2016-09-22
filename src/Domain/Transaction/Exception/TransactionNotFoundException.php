<?php

namespace Leos\Domain\Transaction\Exception;

use Leos\Domain\Common\Exception\NotFoundException;

/**
 * Class TransactionNotFoundException
 *
 * @package Leos\Domain\Transaction\Exception
 */
class TransactionNotFoundException extends NotFoundException
{

    /**
     * TransactionNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('transaction.exception.not_found', 6004);
    }
}
