<?php

namespace Leos\Application\UseCase\Transaction\Request;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Payment\Exception\MinWithdrawalAmountException;

/**
 * Class Withdrawal
 * 
 * @package Leos\Application\UseCase\Transaction\Request
 */
class Withdrawal
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
     * @param string $uid
     * @param string $currency
     * @param float $amountReal
     * @param string $provider
     */
    public function __construct(string $uid, string $currency, float $amountReal, string $provider)
    {
        $this->uid = new WalletId($uid);
        $this->setReal($amountReal, new Currency($currency));
        $this->provider = $provider;
    }

    /**
     * @param float $amount
     * @param Currency $currency
     */
    protected function setReal(float $amount, Currency $currency)
    {
        if (0.00 >= $amount) {

            throw new MinWithdrawalAmountException();
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
