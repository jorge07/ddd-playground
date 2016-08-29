<?php

namespace Leos\Infrastructure\TransactionBundle\Repository;

use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

use Leos\Infrastructure\Common\Doctrine\ORM\Repository\EntityRepository;

/**
 * Class TransactionRepository
 * 
 * @package Leos\Infrastructure\WalletBundle\Repository
 */
class TransactionRepository extends EntityRepository implements TransactionRepositoryInterface
{
    /**
     * @param AbstractTransaction $transaction
     */
    public function save(AbstractTransaction $transaction)
    {
        $this->_em->persist($transaction);
        $this->_em->flush();
    }
}
