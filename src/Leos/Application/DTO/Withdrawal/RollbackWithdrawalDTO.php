<?php

namespace Leos\Application\DTO\Withdrawal;

use Leos\Domain\Transaction\ValueObject\TransactionId;

/**
 * Class RollbackWithdrawalDTO
 * 
 * @package Leos\Application\DTO\Withdrawal
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
