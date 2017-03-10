<?php

declare(strict_types=1);

namespace Leos\Domain\Wallet\Model;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\User\Model\User;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class Wallet
 * 
 * @package Domain\Wallet\Model
 */
class Wallet
{
    /**
     * @var WalletId
     */
    private $id;

    /**
     * @var User
     */
    private $user;

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

    public function __construct(User $user)
    {
        $this->id = new WalletId();
        $this->user = $user;
        $this->real = new Credit(0);
        $this->bonus = new Credit(0);
        $this->createdAt = new \DateTime();
    }

    public function addRealMoney(Money $money): self
    {
        $this->real = $this->real->add($money);

        return $this;
    }

    public function removeRealMoney(Money $money): self
    {
        $this->real = $this->real->remove($money);

        return $this;
    }

    public function addBonusMoney(Money $money): self
    {
        $this->bonus = $this->bonus->add($money);

        return $this;
    }

    public function removeBonusMoney(Money $money): self
    {
        $this->bonus = $this->bonus->remove($money);

        return $this;
    }

    public function id(): string
    {
        return $this->id->__toString();
    }

    public function walletId(): WalletId
    {
        return $this->id;
    }

    public function user(): User
    {
        return $this->user;
    }

    public function real(): Credit
    {
        return $this->real;
    }

    public function bonus(): Credit
    {
        return $this->bonus;
    }

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
