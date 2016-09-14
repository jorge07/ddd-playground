<?php

namespace Leos\Domain\Withdrawal\ValueObject;

/**
 * Class WithdrawalDetails
 * 
 * @package Leos\Domain\Withdrawal\ValueObject
 */
class WithdrawalDetails
{
    /**
     * @var string
     */
    private $provider;

    /**
     * WithdrawalDetails constructor.
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
