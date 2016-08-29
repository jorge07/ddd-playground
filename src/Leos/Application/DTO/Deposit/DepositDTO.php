<?php

namespace Leos\Application\DTO\Deposit;

use Leos\Domain\Deposit\Exception\MinDepositAmountException;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class DepositDTO
 *
 * @package Leos\Application\DTO\Deposit
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
     * DepositDTO constructor.
     *
     * @param WalletId $uid
     * @param Currency $currency
     * @param float $amountReal
     */
    public function __construct(WalletId $uid, Currency $currency, float $amountReal)
    {
        $this->uid = $uid;
        $this->setReal($amountReal, $currency);
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

}
