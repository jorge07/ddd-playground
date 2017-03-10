<?php

namespace Leos\Infrastructure\WalletBundle\Repository;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;
use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;

use Leos\Infrastructure\CommonBundle\Doctrine\ORM\Repository\EntityRepository;

/**
 * Class WalletRepository
 * @package Leos\Infrastructure\WalletBundle\Repository
 */
class WalletRepository extends EntityRepository implements WalletRepositoryInterface
{
    /**
     * @param array $filters
     * @param array $operators
     * @param array $values
     * @param array $sort
     * @return \Pagerfanta\Pagerfanta
     */
    public function findAll(array $filters = [], array $operators = [], array $values = [], array $sort = [])
    {

        $queryBuilder = $this->createQueryBuilder($alias = 'wallet');

        return $this->createOperatorPaginator($queryBuilder, $alias, $filters, $operators, $values, $sort);
    }
    /**
     * @param WalletId $uid
     * @return Wallet
     * @throws WalletNotFoundException
     */
    public function get(WalletId $uid): Wallet
    {
        $wallet = $this->findOneById($uid);

        if (!$wallet) {

            throw new WalletNotFoundException();
        }

        return $wallet;
    }

    public function findOneById(WalletId $uid): ?Wallet
    {
        return $this->createQueryBuilder('wallet')
            ->where('wallet.id = :id')
            ->setParameter('id', $uid->bytes())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
