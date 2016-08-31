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
    public function __construct(Wallet $wallet, Money $real)
    {
        parent::__construct(TransactionType::DEPOSIT, $wallet, $real, new Money(0, $real->currency()));
    }
}
