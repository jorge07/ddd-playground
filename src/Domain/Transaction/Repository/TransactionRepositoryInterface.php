<?php

namespace Leos\Domain\Transaction\Repository;

use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Domain\Transaction\Exception\TransactionNotFoundException;

/**
 * Interface TransactionRepository
 *
 * @package Leos\Domain\Transaction\Repository
 */
interface TransactionRepositoryInterface
{

    /**
     * @param TransactionId $transactionId
     *
     * @return mixed
     *
     * @throws TransactionNotFoundException
     */
    public function get(TransactionId $transactionId): AbstractTransaction;

    /**
     * @param AbstractTransaction $transaction
     * @return void
     */
    public function save(AbstractTransaction $transaction);
}
