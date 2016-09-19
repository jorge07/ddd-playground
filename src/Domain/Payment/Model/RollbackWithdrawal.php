<?php

namespace Leos\Domain\Payment\Model;

use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class RollbackWithdrawal
 *
 * @package Leos\Domain\Payment\Model
 */
class RollbackWithdrawal extends AbstractTransaction
{
    /**
     * RollbackWithdrawal constructor.
     *
     * @param Withdrawal $withdrawal
     */
    public function __construct(Withdrawal $withdrawal)
    {
        parent::__construct(
            TransactionType::ROLLBACK_WITHDRAWAL,
            $withdrawal->wallet(),
            $withdrawal->realMoney(),
            $withdrawal->bonusMoney()
        );

        $this->setReferralTransaction($withdrawal);
        $this->setDetails($withdrawal->details());
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }
}
