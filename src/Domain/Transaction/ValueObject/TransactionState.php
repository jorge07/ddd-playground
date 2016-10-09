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
        $type = (string) $transaction->type();

        switch ($new) {

            case self::ACTIVE:
                $can = self::canActivate($current);
                break;
            case self::PENDING:

                $can = self::canWait($current, $type);
                break;
            case self::REVERTED:
                $can = self::canRevert($current, $type);
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
        return $state !== static::REVERTED;
    }

    /**
     * @param string $state
     * @param string $type
     *
     * @return bool
     */
    private static function canRevert(string $state, string $type): bool
    {
        return $state === static::ACTIVE && !in_array($type, [
            TransactionType::ROLLBACK_DEPOSIT,
            TransactionType::ROLLBACK_WITHDRAWAL
        ]);
    }

    /**
     * @param string $state
     * @param string $type
     *
     * @return bool
     */
    private static function canWait(string $state, string $type): bool
    {
        return $state === static::ACTIVE && !in_array($type, [
            TransactionType::ROLLBACK_DEPOSIT,
            TransactionType::ROLLBACK_WITHDRAWAL
        ]);
    }
}
