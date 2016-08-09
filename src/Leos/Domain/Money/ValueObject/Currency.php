<?php

namespace Leos\Domain\Money\ValueObject;

use Leos\Domain\Money\Exception\CurrencyWrongCodeException;


/**
 * Class Currency
 * @package Domain\Money
 */
class Currency
{
    /**
     * @var string ISO code string
     */
    private $code;

    /**
     * @var float
     */
    private $exchange;

    /**
     * Currency constructor.
     *
     * @param string $code
     * @param float $exchange
     */
    public function __construct(string $code = 'EUR', float $exchange = 1.0)
    {
        $this->setCode($code);
        $this->exchange = $exchange;
    }

    /**
     * @param Currency $currency
     * @return bool
     */
    public function equals(Currency $currency): bool
    {
        return ($currency->getCode() === $this->code && $currency->getExchange() === $this->exchange);
    }

    /**
     * @param string $code
     */
    private function setCode(string $code)
    {
        if (!preg_match('/^[A-Z]{3}$/', $code)) {

            throw new CurrencyWrongCodeException();
        }

        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return float
     */
    public function getExchange(): float
    {
        return $this->exchange;
    }

}
