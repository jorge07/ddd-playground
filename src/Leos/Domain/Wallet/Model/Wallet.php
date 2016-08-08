<?php

namespace Leos\Domain\Wallet\Model;

use Leos\Domain\Money\Model\Money;

/**
 * Class Wallet
 * @package Domain\Wallet\Model
 */
class Wallet
{
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
     * @param Credit $real
     * @param Credit $bonus
     */
    public function __construct(Credit $real, Credit $bonus)
    {
        $this->real = $real;
        $this->bonus = $bonus;
        $this->createdAt = new \DateTime();
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function addRealMoney(Money $money): Wallet
    {
        $this->real = $this->real->add($money);

        return $this;
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function removeRealMoney(Money $money): Wallet
    {
        $this->real = $this->real->remove($money);

        return $this;
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function addBonusMoney(Money $money): Wallet
    {
        $this->bonus = $this->bonus->add($money);

        return $this;
    }

    /**
     * @param Money $money
     *
     * @return Wallet
     */
    public function removeBonusMoney(Money $money): Wallet
    {
        $this->bonus = $this->bonus->remove($money);

        return $this;
    }

    /**
     * @return Credit
     */
    public function getReal(): Credit
    {
        return $this->real;
    }

    /**
     * @return Credit
     */
    public function getBonus(): Credit
    {
        return $this->bonus;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

}
