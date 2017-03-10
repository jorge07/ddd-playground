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
    public function register(array $data): User;
}
