<?php

namespace Leos\Domain\Transaction\Repository;

use Leos\Domain\Transaction\Model\Transaction;

/**
 * Interface TransactionRepository
 *
 * @package Leos\Domain\Transaction\Repository
 */
interface TransactionRepositoryInterface
{

    /**
     * @param Transaction $transaction
     * @return void
     */
    public function save(Transaction $transaction);
}
