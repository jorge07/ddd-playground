<?php

namespace Leos\Infrastructure\TransactionBundle\Repository;

use Leos\Domain\Transaction\Model\Transaction;
use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;

use Leos\Infrastructure\Common\Doctrine\ORM\Repository\EntityRepository;

/**
 * Class TransactionRepository
 * 
 * @package Leos\Infrastructure\WalletBundle\Repository
 */
class TransactionRepository extends EntityRepository implements TransactionRepositoryInterface
{
    /**
     * @param Transaction $transaction
     */
    public function save(Transaction $transaction)
    {
        $this->_em->persist($transaction);
        $this->_em->flush();
    }
}
