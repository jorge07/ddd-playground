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
    public function __construct(Wallet $wallet, Money $real)
    {
        parent::__construct(TransactionType::WITHDRAWAL, $wallet, $real, new Money(0, $real->currency()));
    }

    /**
     * @return RollbackWithdrawal
     */
    public function rollback(): RollbackWithdrawal
    {
        return new RollbackWithdrawal($this);
    }
}
