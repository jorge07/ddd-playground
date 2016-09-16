<?php

namespace Leos\Infrastructure\UserBundle\Doctrine\Types;

use Ramsey\Uuid\Doctrine\UuidBinaryType;

use Doctrine\DBAL\Platforms\AbstractPlatform;

use Leos\Domain\User\ValueObject\UserId;

/**
 * Class UserIdType
 *
 * @package Leos\Infrastructure\WalletBundle\Doctrine\Types
 */
class UserIdType extends UuidBinaryType
{
    const USER_ID = 'userId';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : UserId::fromBytes($value);
    }

    /**
     * @param UserId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return  (null === $value) ? null : $value->bytes();
    }

    public function getName()
    {
        return self::USER_ID;
    }
}
