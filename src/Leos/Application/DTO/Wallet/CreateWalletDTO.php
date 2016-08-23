<?php

namespace Leos\Application\DTO\Wallet;

use Leos\Application\DTO\Transaction\CreditDTO;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class CreateWalletDTO
 *
 * @package Leos\Domain\Wallet\DTO
 */
class CreateWalletDTO
{
    /**
     * @var Credit
     */
    private $initialAmountReal;

    /**
     * @var Credit
     */
    private $initialAmountBonus;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * CreateWalletDTO constructor.
     *
     * @param string $currency
     * @param int $initialAmountReal
     * @param int $initialAmountBonus
     */
    public function __construct(string $currency = Currency::DEFAULT, int $initialAmountReal = 0, int $initialAmountBonus = 0)
    {
        $this->currency = new Currency($currency);
        $this->initialAmountReal = new Money($initialAmountReal, $this->currency);
        $this->initialAmountBonus = new Money($initialAmountBonus, $this->currency);
    }

    /**
     * @return Money
     */
    public function initialAmountReal(): Money
    {
        return $this->initialAmountReal;
    }

    /**
     * @return Money
     */
    public function initialAmountBonus(): Money
    {
        return $this->initialAmountBonus;
    }

    /**
     * @param WalletId $walletId
     * @return CreditDTO
     */
    public function toCreditDTO(WalletId $walletId): CreditDTO
    {
        return new CreditDTO(
            $walletId,
            $this->currency,
            $this->initialAmountReal->amount(),
            $this->initialAmountBonus->amount()
        );
    }

    /**
     * @return bool
     */
    public function hasInitialAmount(): bool
    {
        return (0 < $this->initialAmountReal->amount() || 0 < $this->initialAmountBonus->amount());
    }

    /**
     * @return Currency
     */
    public function currency(): Currency
    {
       return $this->currency;
    }

}
