<?php

namespace Leos\Domain\Payment\Model;

use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionState;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class RollbackDeposit
 *
 * @package Leos\Domain\Payment\Model
 */
class RollbackDeposit extends AbstractTransaction
{
    /**
     * RollbackDeposit constructor.
     *
     * @param Deposit $deposit
     */
    public function __construct(Deposit $deposit)
    {
        parent::__construct(
            TransactionType::ROLLBACK_DEPOSIT,
            $deposit->wallet(),
            $deposit->realMoney(),
            $deposit->bonusMoney()
        );
        $this->setState(TransactionState::ACTIVE);
        $this->setReferralTransaction($deposit);
        $this->setDetails($deposit->details());
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }
}
