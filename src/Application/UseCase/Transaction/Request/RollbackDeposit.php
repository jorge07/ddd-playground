<?php

namespace Leos\Application\UseCase\Transaction\Request;

use Leos\Domain\Transaction\ValueObject\TransactionId;

/**
 * Class RollbackDeposit
 * 
 * @package Leos\Application\UseCase\Transaction\Request
 */
class RollbackDeposit
{
    /**
     * @var TransactionId
     */
    private $depositId;

    /**
     * RollbackDeposit constructor.
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
