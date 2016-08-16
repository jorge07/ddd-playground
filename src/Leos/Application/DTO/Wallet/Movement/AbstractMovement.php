<?php

namespace Leos\Application\DTO\Wallet\Movement;


use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Wallet\ValueObject\WalletId;

abstract class AbstractMovement
{
    /**
     * @var WalletId
     */
    private $uid;

    /**
     * @var Money
     */
    private $real;

    /**
     * @var Money
     */
    private $bonus;

    /**
     * DebitDto constructor.
     *
     * @param WalletId $uid
     * @param Currency $currency
     * @param float $amountReal
     * @param float $amountBonus
     */
    public function __construct(WalletId $uid, Currency $currency, float $amountReal, float $amountBonus)
    {
        $this->uid = $uid;
        $this->real = new Money($amountReal, $currency);
        $this->bonus = new Money($amountBonus, $currency);
    }

    /**
     * @return WalletId
     */
    public function walletId(): WalletId
    {
        return $this->uid;
    }

    /**
     * @return Money
     */
    public function real(): Money
    {
        return $this->real;
    }

    /**
     * @return Money
     */
    public function bonus(): Money
    {
        return $this->bonus;
    }
}
