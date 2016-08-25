<?php

namespace Leos\Domain\User\Repository;

use Leos\Domain\User\Model\User;

/**
 * Interface UserRepositoryInterface
 *
 * @package Leos\Domain\User\Repository
 */
interface UserRepositoryInterface
{
    /**
     * @param string $username
     *
     * @return null|User
     */
    public function findByUsername(string $username);
}
