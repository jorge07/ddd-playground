<?php

namespace Leos\Infrastructure\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Leos\Domain\User\Model\User;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\User\ValueObject\UserId;

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
    public function findOneByUsername(string $username)
    {
        return $this->createQueryBuilder('user')
            ->where('user.auth.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
//            ->useResultCache(true, null, 'user.findByUsername'.$username)
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param UserId $userId
     * @return null|User
     */
    public function findOneById(UserId $userId)
    {
        return $this->createQueryBuilder('user')
            ->where('user.uuid = :id')
            ->setParameter('id', $userId->bytes())
            ->getQuery()
//            ->useResultCache(true, null, 'user.findByUsername'.$username)
            ->getOneOrNullResult()
        ;
    }

    /**
     * @param User $user
     * 
     * @return void
     */
    public function save(User $user)
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

}
