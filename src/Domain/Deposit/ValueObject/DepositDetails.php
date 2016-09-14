<?php

namespace Leos\Domain\Deposit\ValueObject;

/**
 * Class DepositDetails
 * 
 * @package Leos\Domain\Deposit\ValueObject
 */
class DepositDetails
{
    /**
     * @var string
     */
    private $provider;

    /**
     * DepositDetails constructor.
     *
     * @param string $provider
     */
    public function __construct(string $provider)
    {
        $this->setProvider($provider);
    }

    /**
     * @param string $provider
     */
    private function setProvider(string $provider)
    {
        if (strlen($provider) < 3) {
            
            throw new \InvalidArgumentException('payment.exception.invalid_provider', 2200);
        }

        $this->provider = $provider;
    }

    /**
     * @return string
     */
    public function provider(): string
    {
        return $this->provider;
    }
}
