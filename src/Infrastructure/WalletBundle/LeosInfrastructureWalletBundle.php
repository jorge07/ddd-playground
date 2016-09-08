<?php

namespace Leos\Infrastructure\WalletBundle;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LeosInfrastructureWalletBundle extends Bundle
{
    public function boot()
    {
        if (!Type::hasType('walletId')){

            Type::addType('walletId', 'Leos\Infrastructure\WalletBundle\Doctrine\Types\WalletIdType');
        }
    }
}
