<?php

namespace Leos\Domain\Deposit\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Deposit
 *
 * @package Leos\Domain\Deposit\Model
 */
class Deposit extends AbstractTransaction
{
    /**
     * A positive Real money only insertion on user wallet
     * 
     * @param Wallet $wallet
     * @param Money $real
     *
     * @return Deposit
     */
    public static function create(Wallet $wallet, Money $real): Deposit
    {
        return self::getInstance(TransactionType::DEPOSIT, $wallet, $real);
    }
}
