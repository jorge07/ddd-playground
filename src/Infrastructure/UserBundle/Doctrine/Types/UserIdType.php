<?php

namespace Leos\Infrastructure\UserBundle\Doctrine\Types;

use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Leos\Domain\User\ValueObject\UserId;

/**
 * Class UserIdType
 *
 * @package Leos\Infrastructure\WalletBundle\Doctrine\Types
 */
class UserIdType extends GuidType
{
    const USER_ID = 'userId';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : new UserId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return  (null === $value) ? null : (string) $value;
    }

    public function getName()
    {
        return self::USER_ID;
    }
}
