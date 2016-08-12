<?php

namespace Leos\Infrastructure\WalletBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;

/**
 * Class WalletRepository
 * @package Leos\Infrastructure\WalletBundle\Repository
 */
class WalletRepository extends EntityRepository implements WalletRepositoryInterface
{
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

    /**
     * @param WalletId $uid
     *
     * @return null|Wallet
     */
    public function findOneById(WalletId $uid)
    {
        return $this->createQueryBuilder('wallet')
            ->where('wallet.id = :id')
            ->setParameter('id', (string) $uid)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param Wallet $wallet
     * @return void
     */
    public function save(Wallet $wallet)
    {
        $this->_em->persist($wallet);
        $this->_em->flush();
    }
}
