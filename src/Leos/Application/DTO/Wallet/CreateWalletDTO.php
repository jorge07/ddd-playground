<?php

namespace Leos\Application\DTO\Wallet;

use Leos\Domain\Money\ValueObject\Currency;

/**
 * Class CreateWalletDTO
 *
 * @package Leos\Domain\Wallet\DTO
 */
class CreateWalletDTO
{

    /**
     * @var Currency
     */
    private $currency;

    /**
     * CreateWalletDTO constructor.
     *
     * @param string $currency
     */
    public function __construct(string $currency = Currency::DEFAULT)
    {
        $this->currency = new Currency($currency);
    }

    /**
     * @return Currency
     */
    public function currency(): Currency
    {
       return $this->currency;
    }

}
