<?php

namespace Leos\Infrastructure\PaymentBundle;

use Doctrine\DBAL\Types\Type;

use Leos\Domain\Payment\ValueObject\DepositDetails;
use Leos\Domain\Payment\ValueObject\WithdrawalDetails;

use Leos\Infrastructure\CommonBundle\Doctrine\Types\JsonDocumentType;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class LeosInfrastructurePaymentBundle
 *
 * @package Leos\Infrastructure\PaymentBundle
 */
class LeosInfrastructurePaymentBundle extends Bundle
{
    public function boot()
    {
        $this->addDbalType('deposit_details', DepositDetails::class);
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
