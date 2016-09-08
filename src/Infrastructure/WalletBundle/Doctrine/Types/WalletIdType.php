<?php

namespace Leos\Infrastructure\WalletBundle\Doctrine\Types;

use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class WalletType
 *
 * @package Leos\Infrastructure\WalletBundle\Doctrine\Types
 */
class WalletIdType extends GuidType
{
    const WALLET_ID = 'walletId';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new WalletId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function getName()
    {
        return self::WALLET_ID;
    }
}
