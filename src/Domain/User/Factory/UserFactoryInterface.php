<?php

namespace Leos\Domain\User\Factory;

use Leos\Domain\User\Model\User;

/**
 * Interface UserFactoryInterface
 *
 * @package Leos\Domain\User\Factory
 */
interface UserFactoryInterface
{
    /**
     * @param array $data
     *
     * @return User
     */
    public function register(array $data): User;

}
