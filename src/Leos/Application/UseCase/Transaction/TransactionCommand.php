<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\DTO\Deposit\DepositDTO;
use Leos\Application\DTO\Wallet\CreateWalletDTO;
use Leos\Application\DTO\Withdrawal\WithdrawalDTO;
use Leos\Application\UseCase\Wallet\WalletQuery;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Deposit\Model\Deposit;
use Leos\Domain\Withdrawal\Model\Withdrawal;
use Leos\Domain\Wallet\Factory\WalletFactory;

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
     * @param WithdrawalDTO $dto
     * @return Withdrawal
     */
    public function withdrawal(WithdrawalDTO $dto): Withdrawal
    {
        $transaction = Withdrawal::create(
            $this->walletQuery->get($dto->walletId()),
            $dto->real()
        );

        $this->repository->save($transaction);

        return $transaction;
    }

    /**
     * @param DepositDTO $dto
     * @return Deposit
     */
    public function deposit(DepositDTO $dto): Deposit
    {
        $transaction = Deposit::create(
            $this->walletQuery->get($dto->walletId()),
            $dto->real()
        );

        $this->repository->save($transaction);

        return $transaction;
    }

    /**
     * @param CreateWalletDTO $dto
     * @return Wallet
     */
    public function createWallet(CreateWalletDTO $dto): Wallet
    {
        $transaction = WalletFactory::create($dto->currency());

        $this->repository->save($transaction);

        return $transaction->wallet();
    }
}
