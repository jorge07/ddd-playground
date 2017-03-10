<?php

declare(strict_types=1);

namespace Leos\Domain\Money\ValueObject;

use Leos\Domain\Money\Exception\CurrencyWrongCodeException;

/**
 * Class Currency
 *
 * @package Leos\Domain\Money\ValueObject
 */
class Currency
{
    const DEFAULT = 'EUR';
    
    /**
     * @var string ISO code string
     */
    private $code;

    /**
     * @var float
     */
    private $exchange;

    public function __construct(string $code = 'EUR', float $exchange = 1.0)
    {
        $this->setCode($code);
        $this->exchange = $exchange;
    }

    public function equals(Currency $currency): bool
    {
        return ($currency->code() === $this->code && $currency->exchange() === $this->exchange);
    }

    private function setCode(string $code)
    {
        if (!preg_match('/^[A-Z]{3}$/', $code)) {

            throw new CurrencyWrongCodeException();
        }

        $this->code = $code;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function exchange(): float
    {
        return $this->exchange;
    }
}
