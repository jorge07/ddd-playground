<?php

namespace Leos\Infrastructure\DepositBundle;

use Leos\Domain\Deposit\ValueObject\DepositDetails;
use Doctrine\DBAL\Types\Type;
use Leos\Infrastructure\CommonBundle\Doctrine\Types\JsonDocumentType;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LeosInfrastructureDepositBundle extends Bundle
{
    public function boot()
    {
        $this->addDbalType('deposit_details', DepositDetails::class);
    }

    /**
     * @param string $type
     * @param string $object
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    private function addDbalType(string $type, string $object)
    {
        if (!Type::hasType($type)) {

            Type::addType($type, JsonDocumentType::class);

            /** @var JsonDocumentType $type */
            $type = Type::getType($type);

            $type->setSerializer(
                $this->container->get('serializer')
            );

            $type->setType($object);
        }
    }
}
