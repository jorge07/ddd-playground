<?php

namespace Leos\Application\UseCase\Transaction\Request;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Payment\Exception\MinDepositAmountException;

/**
 * Class DepositDTO
 * 
 * @package Leos\Application\UseCase\Transaction\Request
 */
class DepositDTO
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
     * DepositDTO constructor.
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
     * @throws MinDepositAmountException
     */
    protected function setReal(float $amount, Currency $currency)
    {
        if (0.00 >= $amount) {

            throw new MinDepositAmountException();
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
