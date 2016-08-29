<?php

namespace Leos\Domain\Transaction\Repository;

use Leos\Domain\Transaction\Model\AbstractTransaction;

/**
 * Interface TransactionRepository
 *
 * @package Leos\Domain\Transaction\Repository
 */
interface TransactionRepositoryInterface
{

    /**
     * @param AbstractTransaction $transaction
     * @return void
     */
    public function save(AbstractTransaction $transaction);
}
