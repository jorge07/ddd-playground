<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\DTO\Deposit\DepositDTO;
use Leos\Application\DTO\Transaction\DebitDTO;
use Leos\Application\DTO\Transaction\CreditDTO;
use Leos\Application\DTO\Wallet\CreateWalletDTO;
use Leos\Application\UseCase\Wallet\WalletQuery;

use Leos\Domain\Deposit\Model\Deposit;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Transaction\Model\Transaction;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

/**
 * Class TransactionCommand
 *
 * @package Leos\Application\UseCase\Wallet
 */
class TransactionCommand
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $repository;

    /**
     * @var WalletQuery
     */
    private $walletQuery;

    /**
     * TransactionCommand constructor.
     *
     * @param TransactionRepositoryInterface $repository
     * @param WalletQuery $walletQuery
     */
    public function __construct(TransactionRepositoryInterface $repository, WalletQuery $walletQuery)
    {
        $this->repository = $repository;
        $this->walletQuery = $walletQuery;
    }

    /**
     * @param DebitDTO $dto
     * @return Transaction
     */
    public function debit(DebitDTO $dto): Transaction
    {
        $transaction = Transaction::debit($this->walletQuery->get($dto->walletId()), $dto->real(), $dto->bonus());

        $this->repository->save($transaction);

        return $transaction;
    }

    /**
     * @param CreditDTO $dto
     * @return Transaction
     */
    public function credit(CreditDTO $dto): Transaction
    {
        $transaction = Transaction::credit($this->walletQuery->get($dto->walletId()), $dto->real(), $dto->bonus());

        $this->repository->save($transaction);

        return $transaction;
    }

    /**
     * @param DepositDTO $dto
     * @return Transaction
     */
    public function deposit(DepositDTO $dto): Transaction
    {
        $transaction = Deposit::deposit($this->walletQuery->get($dto->walletId()), $dto->real());

        $this->repository->save($transaction);

        return $transaction;
    }

    /**
     * @param CreateWalletDTO $dto
     * @return Wallet
     */
    public function createWallet(CreateWalletDTO $dto): Wallet
    {
        $transaction = Transaction::createWallet($dto->currency());

        $this->repository->save($transaction);

        if ($dto->hasInitialAmount()) {

            $this->repository->save(
                $transaction = $this->credit($dto->toCreditDTO($transaction->wallet()->walletId()))
            );
        }

        return $transaction->wallet();
    }
}
