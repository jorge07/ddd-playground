<?php

namespace Leos\Domain\Deposit\Model;

use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class RollbackDeposit
 *
 * @package Leos\Domain\Deposit\Model
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
            $deposit->realRollback(),
            $deposit->bonusRollback()
        );

        $this->setReferralTransaction($deposit);
    }
}
