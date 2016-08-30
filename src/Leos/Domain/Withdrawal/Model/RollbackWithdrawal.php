<?php

namespace Leos\Domain\Withdrawal\Model;

use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class RollbackWithdrawal
 *
 * @package Leos\Domain\Withdrawal\Model
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
            $withdrawal->realRollback(),
            $withdrawal->bonusRollback()
        );

        $this->setReferralTransaction($withdrawal);
    }
}
