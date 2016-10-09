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
     * @param string $new
     *
     * @return bool
     */
    public static function can(AbstractTransaction $transaction, string $new): bool
    {
        $can = false;

        $current = $transaction->is();
        $type = $transaction->type();

        switch ($new) {

            case self::ACTIVE:
                $can = self::canActivate($current);
                break;
            case self::PENDING:

                $can = self::canWait($current);
                break;
            case self::REVERTED:
                $can = self::canRevert($current);
                break;

        }

        return $can;
    }

    /**
     * @param string $state
     *
     * @return bool
     */
    private static function canActivate(string $state): bool
    {
        return $state === static::REVERTED;
    }

    /**
     * @param string $state
     *
     * @return bool
     */
    private static function canRevert(string $state): bool
    {
        return $state === static::ACTIVE;
    }

    /**
     * @param string $state
     *
     * @return bool
     */
    private static function canWait(string $state): bool
    {
        return $state === static::ACTIVE;
    }
}
