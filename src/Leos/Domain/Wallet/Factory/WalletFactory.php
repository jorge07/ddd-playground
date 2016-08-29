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
     * @param Currency $currency
     *
     * @return AbstractTransaction
     */
    public static function create(Currency $currency): AbstractTransaction
    {
        return self::getInstance(TransactionType::CREATE_WALLET, new Wallet(), new Money(0, $currency), new Money(0, $currency));
    }
}
