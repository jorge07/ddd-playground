<?php
declare(strict_types=1);

namespace Leos\Domain\Wallet\Model;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class Wallet
 * @package Domain\Wallet\Model
 */
final class Wallet
{
    /**
     * @var string
     */
    private $walletId;

    /**
     * @var Credit
     */
    private $real;

    /**
     * @var Credit
     */
    private $bonus;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var null|\DateTime
     */
    private $updatedAt;

    /**
     * Wallet constructor.
     *
     * @param WalletId $walletId
     * @param Credit $real
     * @param Credit $bonus
     */
    public function __construct(WalletId $walletId, Credit $real, Credit $bonus)
    {
        // String until make serialization to not break tests
        $this->walletId = (string) $walletId;
        $this->real = $real;
        $this->bonus = $bonus;
        $this->createdAt = new \DateTime();
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function addRealMoney(Money $money): self
    {
        $this->real = $this->real->add($money);

        return $this;
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function removeRealMoney(Money $money): self
    {
        $this->real = $this->real->remove($money);

        return $this;
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function addBonusMoney(Money $money): self
    {
        $this->bonus = $this->bonus->add($money);

        return $this;
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function removeBonusMoney(Money $money): self
    {
        $this->bonus = $this->bonus->remove($money);

        return $this;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return (string) $this->walletId;
    }

    /**
     * @return Credit
     */
    public function real(): Credit
    {
        return $this->real;
    }

    /**
     * @return Credit
     */
    public function bonus(): Credit
    {
        return $this->bonus;
    }

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function updatedAt()
    {
        return $this->updatedAt;
    }

}
