<?php

namespace Leos\Domain\Transaction\ValueObject;

use Leos\Domain\Transaction\Model\AbstractTransaction;

/**
 * Class TransactionState
 *
 * @package Leos\Domain\Transaction\ValueObject
 */
class TransactionState
{
    const
        ACTIVE = 'active',
        PENDING = 'pending',
        REVERTED = 'reverted'
    ;

    /**
     * @param AbstractTransaction $transaction
     *
     * @return void
     */
    public static function confirm(AbstractTransaction $transaction)
    {
        if ($transaction->is() === static::PENDING) {

            $transaction->setState(static::ACTIVE);
        }
    }

    /**
     * @param AbstractTransaction $transaction
     *
     * @return void
     */
    public static function rollback(AbstractTransaction $transaction)
    {
        if ($transaction->is() === static::ACTIVE) {

            $transaction->setState(static::REVERTED);
        }
    }
}
