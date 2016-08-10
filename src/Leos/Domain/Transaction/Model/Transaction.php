<?php
declare(strict_types=1);

namespace Leos\Domain\Transaction\Model;

use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Transaction
 *
 * @package Leos\Domain\Transaction\Model
 */
class Transaction
{
    /**
     * @var TransactionId
     */
    private $id;

    /**
     * @var TransactionType
     */
    private $type;
    
    /**
     * @var
     */
    private $referralTransaction;

    /**
     * Transaction constructor.
     *
     * @param TransactionId $transactionId
     * @param TransactionType $type
     */
    public function __construct(TransactionId $transactionId, TransactionType $type)
    {
        $this->id = $transactionId;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return (string) $this->id;
    }

    /**
     * @return TransactionType
     */
    public function type(): TransactionType
    {
        return $this->type;
    }

    /**
     * @return Transaction
     */
    public function referralTransaction()
    {
        return $this->referralTransaction;
    }

    /**
     * @param Transaction $referralTransaction
     *
     * @return Transaction
     */
    public function setReferralTransaction(Transaction $referralTransaction): self
    {
        $this->referralTransaction = $referralTransaction;

        return $this;
    }
}
