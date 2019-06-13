<?php
declare(strict_types=1);

namespace Leos\Domain\Transaction\Model;

use Leos\Domain\Common\AggregateRoot;
use Leos\Domain\Transaction\Event\TransactionWasCreated;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Domain\Transaction\ValueObject\TransactionType;
use Leos\Domain\Transaction\ValueObject\TransactionState;
use Leos\Domain\Transaction\Exception\InvalidTransactionStateException;

/**
 * Class Transaction
 *
 * @package Leos\Domain\Transaction\Model
 */
abstract class AbstractTransaction extends AggregateRoot
{
    /**
     * @var TransactionType
     */
    protected $type;

    /**
     * @var string
     */
    private $state = TransactionState::PENDING;

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

    public function __construct(
        string $type,
        Wallet $wallet,
        Money $real,
        Money $bonus
    )
    {
        parent::__construct(new TransactionId());

        $this->type = new TransactionType($type);
        $this->wallet = $wallet;
        $this->prevReal = $wallet->real();
        $this->prevBonus = $wallet->bonus();
        $this->currency = $real->currency();
        $this->process($real, $bonus);
        $this->createdAt = new \DateTime();
    }

    protected function raiseEvent(): void
    {
        $this->raise(
            new TransactionWasCreated(
                $this->uuid(),
                $this->type()->__toString(),
                $this->wallet->walletId(),
                $this->wallet->user()->uuid(),
                $this->operationReal(),
                $this->operationBonus(),
                $this->currency(),
                $this->createdAt()
            )
        );
    }

    private function process(Money $real, Money $bonus): void
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

    public function realMoney(): Money
    {
        return (new Credit((int) abs($this->operationReal)))
            ->toMoney($this->currency());
    }

    public function bonusMoney(): Money
    {
        return (new Credit((int) abs($this->operationBonus)))
            ->toMoney($this->currency());
    }

    public function type(): TransactionType
    {
        return $this->type;
    }

    public function is(): string
    {
        return $this->state;
    }

    /**
     * @param string $newState
     *
     * @return AbstractTransaction
     *
     * @throws InvalidTransactionStateException
     */
    final protected function setState(string $newState): self
    {
        if (!TransactionState::can($this, $newState)) {

            throw new InvalidTransactionStateException();
        }

        $this->state = $newState;

        return $this;
    }

    public function operationReal(): int
    {
        return $this->operationReal;
    }

    public function operationBonus(): int
    {
        return $this->operationBonus;
    }

    public function prevReal(): Credit
    {
        return $this->prevReal;
    }

    public function prevBonus(): Credit
    {
        return $this->prevBonus;
    }

    public function wallet(): Wallet
    {
        return $this->wallet;
    }

    public function currency(): Currency
    {
        return $this->currency;
    }

    public function createdAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function updatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public abstract function details();

    /**
     * @param mixed $details
     * 
     * @return AbstractTransaction
     */
    public function setDetails($details): self
    {
        $this->details = $details;

        return $this;
    }

    public function referralTransaction(): ?AbstractTransaction
    {
        return $this->referralTransaction;
    }

    protected function setReferralTransaction(AbstractTransaction $referralTransaction): self
    {
        $this->referralTransaction = $referralTransaction;

        return $this;
    }

    public function rollback()
    {
        // Implement when need it
    }
}
