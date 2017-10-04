<?php

namespace Leos\Infrastructure\CommonBundle\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Leos\Infrastructure\CommonBundle\Event\EventAwareId;
use Ramsey\Uuid\Doctrine\UuidBinaryType;

class EventType extends UuidBinaryType
{
    const NAME = 'event';

    /**
     * @param null|string $value
     * @param AbstractPlatform $platform
     * @return \Leos\Domain\Common\ValueObject\AggregateRootId|null
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return (null === $value) ? null : EventAwareId::fromBytes($value);
    }

    /**
     * @param EventAwareId $value
     * @param AbstractPlatform $platform
     * @return null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return  (null === $value) ? null : $value->bytes();
    }

    public function getName()
    {
        return self::NAME;
    }
}
