<?php

namespace Leos\Domain\Payment\ValueObject;

use Leos\Domain\Payment\Exception\InvalidProviderException;

/**
 * Class DepositDetails
 * 
 * @package Leos\Domain\Payment\ValueObject
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
            
            throw new InvalidProviderException();
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
