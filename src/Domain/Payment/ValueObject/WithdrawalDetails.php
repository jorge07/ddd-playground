<?php

namespace Leos\Domain\Payment\ValueObject;
use Leos\Domain\Payment\Exception\InvalidProviderException;

/**
 * Class WithdrawalDetails
 * 
 * @package Leos\Domain\Payment\ValueObject
 */
class WithdrawalDetails
{
    /**
     * @var string
     */
    private $provider;

    public function __construct(string $provider)
    {
        $this->setProvider($provider);
    }

    private function setProvider(string $provider): void
    {
        if (strlen($provider) < 3) {

            throw new InvalidProviderException();
        }

        $this->provider = $provider;
    }

    public function provider(): string
    {
        return $this->provider;
    }
}
