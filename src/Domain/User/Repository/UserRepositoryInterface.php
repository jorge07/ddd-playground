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

    public function getOneByUuid(UserId $userId): User;
    public function findOneByUuid(UserId $userId): ?User;

    public function findOneByUsername(string $username): ?User;

    public function save(User $user): void;
}
