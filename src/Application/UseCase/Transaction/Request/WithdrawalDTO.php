<?php

namespace Leos\Application\UseCase\Transaction\Request;

use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class WithdrawalDTO
 * 
 * @package Leos\Application\UseCase\Transaction\Request
 */
class WithdrawalDTO
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
     * @var string
     */
    private $provider;

    /**
     * WithdrawalDTO constructor.
     *
     * @param WalletId $uid
     * @param Currency $currency
     * @param float $amountReal
     * @param string $provider
     */
    public function __construct(WalletId $uid, Currency $currency, float $amountReal, string $provider)
    {
        $this->uid = $uid;
        $this->setReal($amountReal, $currency);
        $this->provider = $provider;
    }

    /**
     * @param float $amount
     * @param Currency $currency
     *
     */
    protected function setReal(float $amount, Currency $currency)
    {
        if (0.00 >= $amount) {
            // TODO add exception
        }

        $this->real = new Money($amount, $currency);
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
     * @return string
     */
    public function provider(): string
    {
        return $this->provider;
    }
}
