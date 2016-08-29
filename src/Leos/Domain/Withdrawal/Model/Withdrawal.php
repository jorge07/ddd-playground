<?php

namespace Leos\Domain\Withdrawal\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Withdrawal
 *
 * @package Leos\Domain\Withdrawal\Model
 */
class Withdrawal extends AbstractTransaction
{
    /**
     * @param Wallet $wallet
     * @param Money $real
     *
     * @return Withdrawal
     */
    public static function create(Wallet $wallet, Money $real): Withdrawal
    {
        return self::getInstance(TransactionType::WITHDRAWAL, $wallet, $real);
    }
}
