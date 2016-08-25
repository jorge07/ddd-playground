<?php

namespace Leos\Infrastructure\UserBundle;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LeosInfrastructureUserBundle
 *
 * @package Leos\Infrastructure\UserBundle
 */
class LeosInfrastructureUserBundle extends Bundle
{
    /**
     * @throws \Doctrine\DBAL\DBALException
     */
    public function boot()
    {
        if (!Type::hasType('userId')){

            Type::addType('userId', 'Leos\Infrastructure\UserBundle\Doctrine\Types\UserIdType');
        }
    }
}
