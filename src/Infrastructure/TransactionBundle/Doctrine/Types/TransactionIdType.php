<?php

namespace Leos\Infrastructure\TransactionBundle\Doctrine\Types;

use Doctrine\DBAL\Types\GuidType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

use Leos\Domain\Transaction\ValueObject\TransactionId;

/**
 * Class TransactionType
 *
 * @package Leos\Infrastructure\TransactionBundle\Doctrine\Types
 */
class TransactionIdType extends GuidType
{
    const TRANSACTION_ID = 'transactionId';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        return new TransactionId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }
        
        return (string) $value;
    }

    public function getName()
    {
        return self::TRANSACTION_ID;
    }
}
