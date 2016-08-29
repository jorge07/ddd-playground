<?php
declare(strict_types=1);

namespace Leos\Domain\Wallet\ValueObject;

use Leos\Domain\Money\ValueObject\Currency;
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
    private $generatedAt;

    /**
     * Credit constructor.
     * @param int $amount
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
        $this->generatedAt = new \DateTime();
    }

    /**
     * @param Money $money
     * 
     * @return Credit
     */
    public static function moneyToCredit(Money $money): self
    {
        return new self(intval($money->amount() * 100));
    }


    /**
     * @param Currency $currency
     * @return Money
     */
    public function toMoney(Currency $currency): Money
    {
        return new Money(floatval($this->amount() / 100), $currency);
    }

    /**
     * @param Money $money
     *
     * @return Credit
     */
    public function add(Money $money): self
    {
        return new self($this->amount + self::moneyToCredit($money)->amount());
    }

    /**
     * @param Money $money
     *
     * @return Credit
     */
    public function remove(Money $money): self
    {
        if ($this->amount < self::moneyToCredit($money)->amount()) {

            throw new CreditNotEnoughException();
        }

        return new self($this->amount - self::moneyToCredit($money)->amount());
    }

    /**
     * @param Credit $credit
     * @return bool
     */
    public function equals(Credit $credit): bool
    {
        return ($this->amount === $credit->amount());
    }

    /**
     * @return int
     */
    public function amount(): int
    {
        return $this->amount;
    }

    /**
     * @param Credit $credit
     * 
     * @return int
     */
    public function diff(Credit $credit): int
    {
        return $this->amount - $credit->amount();
    }

    /**
     * @return \DateTime
     */
    public function generatedAt(): \DateTime
    {
        return $this->generatedAt;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->amount;
    }
}
