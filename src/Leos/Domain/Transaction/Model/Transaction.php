<?php
declare(strict_types=1);

namespace Leos\Domain\Transaction\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Transaction\ValueObject\TransactionId;
use Leos\Domain\Transaction\ValueObject\TransactionType;

/**
 * Class Transaction
 *
 * @package Leos\Domain\Transaction\Model
 */
class Transaction
{
    /**
     * @var TransactionId
     */
    private $id;

    /**
     * @var TransactionType
     */
    private $type;

    /**
     * @var Credit
     */
    private $prevReal;

    /**
     * @var Credit
     */
    private $prevBonus;

    /**
     * @var int
     */
    private $operationReal;

    /**
     * @var int
     */
    private $operationBonus;

    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * @var null|Transaction
     */
    private $referralTransaction;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var null|\DateTime
     */
    private $updatedAt;

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
        $this->wallet = $wallet;
        $this->prevReal = $wallet->real();
        $this->prevBonus = $wallet->bonus();
        $this->process($real, $bonus);
        $this->createdAt = new \DateTime();
    }

    /**
     * @param Wallet $wallet
     * @param Money $real
     * @param Money $bonus
     *
     * @return Transaction
     */
    public static function debit(Wallet $wallet, Money $real, Money $bonus): Transaction
    {
        return self::getInstance(TransactionType::DEBIT, $wallet, $real, $bonus);
    }

    /**
     * @param Wallet $wallet
     * @param Money $real
     * @param Money $bonus
     *
     * @return Transaction
     */
    public static function credit(Wallet $wallet, Money $real, Money $bonus): Transaction
    {
        return self::getInstance(TransactionType::CREDIT, $wallet, $real, $bonus);
    }

    /**
     * @param string $type
     * @param Wallet $wallet
     * @param Money $real
     * @param Money $bonus
     *
     * @return Transaction
     */
    private static function getInstance(string $type, Wallet $wallet, Money $real, Money $bonus): Transaction
    {
        return new self(new TransactionId(), new TransactionType($type), $wallet, $real, $bonus);
    }

    /**
     * @param Money $real
     * @param Money $bonus
     */
    private function process(Money $real, Money $bonus)
    {
        switch ((string) $this->type()){

            case TransactionType::DEBIT:

                $this->wallet
                    ->removeRealMoney($real)
                    ->removeBonusMoney($bonus)
                ;

                $this->operationReal = - Credit::moneyToCredit($real)->amount();
                $this->operationBonus = - Credit::moneyToCredit($bonus)->amount();

                break;

            case TransactionType::CREDIT:

                $this->wallet
                    ->addRealMoney($real)
                    ->addBonusMoney($bonus)
                ;

                $this->operationReal = Credit::moneyToCredit($real)->amount();
                $this->operationBonus = Credit::moneyToCredit($bonus)->amount();

                break;

            default:
                throw new \LogicException('transaction.exception.unknown_type');
        }
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
     * @return Transaction
     */
    public function referralTransaction()
    {
        return $this->referralTransaction;
    }

    /**
     * @param Transaction $referralTransaction
     *
     * @return Transaction
     */
    public function setReferralTransaction(Transaction $referralTransaction): self
    {
        $this->referralTransaction = $referralTransaction;

        return $this;
    }
}
