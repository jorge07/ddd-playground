<?php

namespace Leos\Infrastructure\WalletBundle\Doctrine\Types;

use Ramsey\Uuid\Doctrine\UuidBinaryType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class WalletType
 *
 * @package Leos\Infrastructure\WalletBundle\Doctrine\Types
 */
class WalletIdType extends UuidBinaryType
{
    const WALLET_ID = 'walletId';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : WalletId::fromBytes($value);
    }

    /**
     * @param WalletId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : $value->bytes();
    }

    public function getName()
    {
        return self::WALLET_ID;
    }
}
