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
     * @param TransactionId $transactionId
     * @param TransactionType $type
     * @param Wallet $wallet
     * @param Money $real
     * @param Money $bonus
     */
    private function __construct(
        TransactionId $transactionId,
        TransactionType $type,
        Wallet $wallet,
        Money $real,
        Money $bonus
    )
    {
        $this->id = $transactionId;
        $this->type = $type;
        $this->wallet = $wallet;
        $this->prevReal = $wallet->real();
        $this->prevBonus = $wallet->bonus();
        $this->currency = $real->currency();
        $this->process($real, $bonus);
        $this->createdAt = new \DateTime();
    }

    /**
     * @param string $type
     * @param Wallet $wallet
     * @param Money $real
     * @param Money|null $bonus
     *
     * @return AbstractTransaction
     */
    final protected static function getInstance(string $type, Wallet $wallet, Money $real, Money $bonus = null): AbstractTransaction
    {
        return new static(new TransactionId(), new TransactionType($type), $wallet, $real, $bonus ?: new Money(0, $real->currency()));
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
    public function setReferralTransaction(AbstractTransaction $referralTransaction): self
    {
        $this->referralTransaction = $referralTransaction;

        return $this;
    }
}
