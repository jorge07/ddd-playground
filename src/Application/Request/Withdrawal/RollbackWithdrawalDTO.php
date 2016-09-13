<?php

namespace Leos\Application\Request\Withdrawal;

use Leos\Domain\Transaction\ValueObject\TransactionId;

/**
 * Class RollbackWithdrawalDTO
 * 
 * @package Leos\Application\Request\Withdrawal
 */
class RollbackWithdrawalDTO
{
    /**
     * @var TransactionId
     */
    private $withdrawalId;

    /**
     * RollbackDepositDTO constructor.
     *
     * @param string $withdrawalId
     */
    public function __construct(string $withdrawalId)
    {
        $this->withdrawalId = new TransactionId($withdrawalId);
    }

    public function withdrawalId(): TransactionId
    {
        return $this->withdrawalId;
    }
}
