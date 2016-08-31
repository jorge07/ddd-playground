<?php

namespace Leos\Application\DTO\Deposit;

use Leos\Domain\Transaction\ValueObject\TransactionId;

/**
 * Class RollbackDepositDTO
 *
 * @package Leos\Application\DTO\Deposit
 */
class RollbackDepositDTO
{
    /**
     * @var TransactionId
     */
    private $depositId;

    /**
     * RollbackDepositDTO constructor.
     *
     * @param string $depositId
     */
    public function __construct(string $depositId)
    {
        $this->depositId = new TransactionId($depositId);
    }

    public function depositId(): TransactionId
    {
        return $this->depositId;
    }
}
