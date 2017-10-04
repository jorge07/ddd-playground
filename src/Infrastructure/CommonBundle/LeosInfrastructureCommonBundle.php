<?php

namespace Leos\Infrastructure\CommonBundle;

use Doctrine\DBAL\Types\Type;
use Leos\Infrastructure\CommonBundle\Doctrine\Types\JsonDocumentType;
use Leos\Infrastructure\CommonBundle\Event\EventAware;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LeosInfrastructureCommonBundle extends Bundle
{
    public function boot()
    {
        parent::boot();

        // Initialize Event Publisher
        $this->container->get('Leos\Domain\Common\Event\EventDispatcherInterface');

        $this->addDBALType('event', EventAware::class);
    }

    /**
     * @param string $type
     * @param string $object
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    private function addDBALType(string $type, string $object): void
    {
        if (!Type::hasType($type)) {

            Type::addType($type, JsonDocumentType::class);

            /** @var JsonDocumentType $type */
            $type = Type::getType($type);

            $type->setSerializer(
                $this->container->get('jms_serializer')
            );

            $type->setType($object);
        }
    }
}
