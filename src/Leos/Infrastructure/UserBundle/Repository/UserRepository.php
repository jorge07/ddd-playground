<?php

namespace Leos\Infrastructure\UserBundle\Repository;

use Leos\Domain\User\Model\User;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Infrastructure\Common\Doctrine\ORM\Repository\EntityRepository;

/**
 * Class UserRepository
 * 
 * @package Leos\Infrastructure\UserBundle\Repository
 */
class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * @param string $username
     *
     * @return null|User
     */
    public function findByUsername(string $username)
    {
        return $this->createQueryBuilder('user')
            ->where('user.auth.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
//            ->useResultCache(true, null, 'user.findByUsername'.$username)
            ->getOneOrNullResult()
        ;
    }
}
