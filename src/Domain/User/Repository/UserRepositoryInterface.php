<?php

namespace Leos\Domain\User\Repository;

use Leos\Domain\User\Model\User;
use Leos\Domain\User\ValueObject\UserId;

/**
 * Interface UserRepositoryInterface
 *
 * @package Leos\Domain\User\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param UserId $userId
     * @return null|User
     */
    public function findOneById(UserId $userId);
    
    /**
     * @param string $username
     *
     * @return null|User
     */
    public function findOneByUsername(string $username);

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user);
}
