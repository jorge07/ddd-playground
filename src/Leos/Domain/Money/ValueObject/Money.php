<?php
declare(strict_types=1);

namespace Leos\Domain\Money\ValueObject;

/**
 * Class Money
 * @package Domain\Money
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

    /**
     * Money constructor.
     * @param float $amount
     * @param Currency $currency
     */
    public function __construct(float $amount = 0, Currency $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function amount(): float
    {
        return $this->amount;
    }

    /**
     * @return Currency
     */
    public function currency(): Currency
    {
        return $this->currency;
    }
}
