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

    public function __construct(int $amount)
    {
        $this->amount = $amount;
        $this->generatedAt = new \DateTime();
    }

    public static function moneyToCredit(Money $money): self
    {
        return new self(intval($money->amount() * 100));
    }

    public function toMoney(Currency $currency): Money
    {
        return new Money(floatval($this->amount() / 100), $currency);
    }

    public function add(Money $money): self
    {
        return new self($this->amount + self::moneyToCredit($money)->amount());
    }

    public function remove(Money $money): self
    {
        if ($this->amount < self::moneyToCredit($money)->amount()) {

            throw new CreditNotEnoughException();
        }

        return new self($this->amount - self::moneyToCredit($money)->amount());
    }

    public function equals(Credit $credit): bool
    {
        return ($this->amount === $credit->amount());
    }

    public function amount(): int
    {
        return $this->amount;
    }

    public function diff(Credit $credit): int
    {
        return $this->amount - $credit->amount();
    }

    public function generatedAt(): \DateTime
    {
        return $this->generatedAt;
    }

    public function __toString(): string
    {
        return (string) $this->amount;
    }
}
