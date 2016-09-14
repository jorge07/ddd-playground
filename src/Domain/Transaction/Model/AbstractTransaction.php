<?php
declare(strict_types=1);

namespace Leos\Domain\Transaction\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Money\ValueObject\Currency;

use Leos\Domain\Money\ValueObject\Money;

use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Transaction
 *
 * @package Leos\Domain\Transaction\Model
 */
abstract class AbstractTransaction
{
    /**
     * @var TransactionId
     */
    protected $id;

    /**
     * @var TransactionType
     *
     * @internal
     */
    private $type;

    /**
     * @var Credit
     */
    protected $prevReal;

    /**
     * @var Credit
     */
    protected $prevBonus;

    /**
     * @var int
     */
    protected $operationReal = 0;

    /**
     * @var int
     */
    protected $operationBonus = 0;

    /**
     * @var Wallet
     */
    protected $wallet;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var mixed
     */
    protected $details;

    /**
     * @var null|AbstractTransaction
     */
    protected $referralTransaction;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var null|\DateTime
     */
    protected $updatedAt;

    /**
     * Transaction constructor.
     *
     * @param string $type
     * @param Wallet $wallet
     * @param Money $real
     * @param Money $bonus
     */
    public function __construct(
        string $type,
        Wallet $wallet,
        Money $real,
        Money $bonus
    )
    {
        $this->id = new TransactionId();
        $this->type = new TransactionType($type);
        $this->wallet = $wallet;
        $this->prevReal = $wallet->real();
        $this->prevBonus = $wallet->bonus();
        $this->currency = $real->currency();
        $this->process($real, $bonus);
        $this->createdAt = new \DateTime();
    }

    /**
     * @param Money $real
     * @param Money $bonus
     */
    private function process(Money $real, Money $bonus)
    {
        switch (true){

            case $this->type()->isDebit():

                $this->wallet
                    ->removeRealMoney($real)
                    ->removeBonusMoney($bonus)
                ;

                break;

            case $this->type()->isCredit():

                $this->wallet
                    ->addRealMoney($real)
                    ->addBonusMoney($bonus)
                ;

                break;
            case (string) $this->type() === TransactionType::CREATE_WALLET:

                break;

            default:
                throw new \LogicException('transaction.exception.unknown_type');
        }

        $this->operationReal = $this->wallet->real()->diff($this->prevReal);
        $this->operationBonus = $this->wallet->bonus()->diff($this->prevBonus);
    }

    /**
     * @return Money
     */
    public function realMoney(): Money
    {
        return (new Credit(abs($this->operationReal)))->toMoney($this->currency());
    }

    /**
     * @return Money
     */
    public function bonusMoney(): Money
    {
        return (new Credit(abs($this->operationBonus)))->toMoney($this->currency());
    }
    
    /**
     * @return string
     */
    public function id(): string
    {
        return (string) $this->id;
    }

    /**
     * @return TransactionType
     */
    public function type(): TransactionType
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function operationReal(): int
    {
        return $this->operationReal;
    }

    /**
     * @return int
     */
    public function operationBonus(): int
    {
        return $this->operationBonus;
    }

    /**
     * @return Credit
     */
    public function prevReal(): Credit
    {
        return $this->prevReal;
    }

    /**
     * @return Credit
     */
    public function prevBonus(): Credit
    {
        return $this->prevBonus;
    }

    /**
     * @return Wallet
     */
    public function wallet(): Wallet
    {
        return $this->wallet;
    }

    /**
     * @return Currency
     */
    public function currency(): Currency
    {
        return $this->currency;
    }

    /**
     * @return \DateTime
     */
    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return null|\DateTime
     */
    public function updatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public abstract function details();

    /**
     * @param $details
     * 
     * @return AbstractTransaction
     */
    public function setDetails($details): self
    {
        $this->details = $details;

        return $this;
    }

    /**
     * @return null|AbstractTransaction
     */
    public function referralTransaction()
    {
        return $this->referralTransaction;
    }

    /**
     * @param AbstractTransaction $referralTransaction
     *
     * @return AbstractTransaction
     */
    protected function setReferralTransaction(AbstractTransaction $referralTransaction): self
    {
        $this->referralTransaction = $referralTransaction;

        return $this;
    }
}
