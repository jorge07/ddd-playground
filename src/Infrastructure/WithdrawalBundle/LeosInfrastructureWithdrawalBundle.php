<?php

namespace Leos\Infrastructure\WithdrawalBundle;

use Doctrine\DBAL\Types\Type;
use Leos\Domain\Withdrawal\ValueObject\WithdrawalDetails;
use Leos\Infrastructure\CommonBundle\Doctrine\Types\JsonDocumentType;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LeosInfrastructureWithdrawalBundle extends Bundle
{
    public function boot()
    {
        $this->addDbalType('withdrawal_details', WithdrawalDetails::class);
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
