<?php

namespace Leos\Domain\Wallet\Model;

use Leos\Domain\Money\Model\Money;
use Leos\Domain\Wallet\Exception\Credit\CreditNotEnoughException;

/**
 * Class Credit
 *
 * @package Domain\Wallet\Model
 */
class Credit
{
    /**
     * @var int
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Credit constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
        $this->createdAt = new \DateTime();
    }

    /**
     * @param Money $money
     * @return int
     */
    public static function moneyToCredit(Money $money): int
    {
        return (int) number_format($money->getAmount() * 100, 0);
    }

    /**
     * @param Money $money
     *
     * @return Credit
     */
    public function add(Money $money): Credit
    {
        return new self($this->amount + self::moneyToCredit($money));
    }

    /**
     * @param Money $money
     *
     * @return Credit
     */
    public function remove(Money $money): Credit
    {
        if ($this->amount < self::moneyToCredit($money)) {

            throw new CreditNotEnoughException();
        }

        return new self($this->amount - self::moneyToCredit($money));
    }

    /**
     * @param Credit $credit
     * @return bool
     */
    public function equals(Credit $credit): bool
    {
        return ($this->amount === $credit->getAmount());
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
}
