<?php

namespace Leos\Domain\Wallet\Model;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Wallet\Exception\Credit\CreditNotEnoughException;

/**
 * Class Credit
 *
 * @package Domain\Wallet\Model
 */
final class Credit
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
     * @return Credit
     */
    public static function moneyToCredit(Money $money): Credit
    {
        return new self((int) number_format($money->getAmount() * 100, 0));
    }

    /**
     * @param Money $money
     *
     * @return Credit
     */
    public function add(Money $money): Credit
    {
        return new self($this->amount + self::moneyToCredit($money)->getAmount());
    }

    /**
     * @param Money $money
     *
     * @return Credit
     */
    public function remove(Money $money): Credit
    {
        if ($this->amount < self::moneyToCredit($money)->getAmount()) {

            throw new CreditNotEnoughException();
        }

        return new self($this->amount - self::moneyToCredit($money)->getAmount());
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
