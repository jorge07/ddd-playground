<?php

namespace Leos\Domain\Wallet\Factory;

use Leos\Domain\User\Model\User;
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
    public function __construct(User $user, Currency $currency)
    {
        parent::__construct(TransactionType::CREATE_WALLET, new Wallet($user), new Money(0, $currency), new Money(0, $currency));
    }

    public static function create(User $user, Currency $currency): self
    {
        $transaction = new self($user, $currency);

        $transaction->raiseEvent();

        return $transaction;
    }

    /**
     * @return mixed
     */
    public function details()
    {
        return $this->details;
    }
}
