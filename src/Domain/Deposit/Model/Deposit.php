<?php

namespace Leos\Domain\Deposit\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Deposit\ValueObject\DepositDetails;
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
     * Deposit constructor.
     * @param Wallet $wallet
     * @param Money $real
     * @param DepositDetails $details
     */
    public function __construct(Wallet $wallet, Money $real, DepositDetails $details)
    {
        parent::__construct(TransactionType::DEPOSIT, $wallet, $real, new Money(0, $real->currency()));

        $this->details = $details;
    }

    /**
     * @return RollbackDeposit
     */
    public function rollback(): RollbackDeposit
    {
        return new RollbackDeposit($this);
    }

    /**
     * @return DepositDetails
     */
    public function details(): DepositDetails
    {
        return $this->details;
    }
}
