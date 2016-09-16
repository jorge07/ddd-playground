<?php

namespace Leos\Infrastructure\TransactionBundle\Doctrine\Types;

use Ramsey\Uuid\Doctrine\UuidBinaryType;

use Doctrine\DBAL\Platforms\AbstractPlatform;

use Leos\Domain\Transaction\ValueObject\TransactionId;

/**
 * Class TransactionType
 *
 * @package Leos\Infrastructure\TransactionBundle\Doctrine\Types
 */
class TransactionIdType extends UuidBinaryType
{
    const TRANSACTION_ID = 'transactionId';
    
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : TransactionId::fromBytes($value);
    }

    /**
     * @param TransactionId $value
     * @param AbstractPlatform $platform
     * @return null|string
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (is_string($value)) {

            return TransactionId::toBytes($value);
        }
        
        return (null === $value) ? null : $value->bytes();
    }

    public function getName()
    {
        return self::TRANSACTION_ID;
    }
}
