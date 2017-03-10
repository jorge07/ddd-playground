<?php

declare(strict_types=1);

namespace Leos\Domain\Money\ValueObject;

/**
 * Class Money
 *
 * @package Leos\Domain\Money\ValueObject
 */
class Money
{
    /**
     * @var float
     */
    private $amount;
    
    /**
     * @var Currency
     */
    private $currency;

    public function __construct(float $amount = 0.00, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }
}
