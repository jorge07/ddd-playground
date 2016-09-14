<?php

namespace Leos\Domain\Wallet\Factory;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Transaction\Model\AbstractTransaction;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class WalletFactory
 *
 * @package Leos\Domain\Wallet\Factory
 */
class WalletFactory extends AbstractTransaction
{
    /**
     * WalletFactory constructor.
     *
     * @param Currency $currency
     */
    public function __construct(Currency $currency)
    {
        parent::__construct(TransactionType::CREATE_WALLET, new Wallet(), new Money(0, $currency), new Money(0, $currency));
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }
}
