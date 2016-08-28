<?php

namespace Leos\Domain\Deposit\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Transaction\Model\Transaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Deposit
 *
 * @package Leos\Domain\Deposit\Model
 */
class Deposit extends Transaction
{
    /**
     * @param Wallet $wallet
     * @param Money $real
     *
     * @return Deposit
     */
    public static function deposit(Wallet $wallet, Money $real)
    {
        return self::getInstance(TransactionType::DEPOSIT, $wallet, $real, new Money(0, $real->currency()));
    }
}
