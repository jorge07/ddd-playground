<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Wallet\WalletQuery;
use Leos\Application\UseCase\Transaction\Request\DepositDTO;
use Leos\Application\UseCase\Transaction\Request\WithdrawalDTO;
use Leos\Application\UseCase\Transaction\Request\CreateWalletDTO;
use Leos\Application\UseCase\Transaction\Request\RollbackDepositDTO;
use Leos\Application\UseCase\Transaction\Request\RollbackWithdrawalDTO;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Payment\Model\Deposit;
use Leos\Domain\Payment\Model\Withdrawal;
use Leos\Domain\Wallet\Factory\WalletFactory;
use Leos\Domain\Payment\Model\RollbackDeposit;
use Leos\Domain\Payment\Model\RollbackWithdrawal;
use Leos\Domain\Payment\ValueObject\DepositDetails;
use Leos\Domain\Payment\ValueObject\WithdrawalDetails;

use Leos\Domain\Transaction\Exception\InvalidTransactionTypeException;
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
     *
     * @return Withdrawal
     */
    public function withdrawal(WithdrawalDTO $dto): Withdrawal
    {
        $this->repository->save(
            $transaction = new Withdrawal(
                $this->walletQuery->get($dto->walletId()),
                $dto->real(),
                new WithdrawalDetails($dto->provider())
            )
        );

        return $transaction;
    }

    /**
     * @param RollbackWithdrawalDTO $dto
     *
     * @return RollbackWithdrawal
     * @throws InvalidTransactionTypeException
     */
    public function rollbackWithdrawal(RollbackWithdrawalDTO $dto): RollbackWithdrawal
    {
        $withdrawal = $this->repository->get($dto->withdrawalId());

        if (!$withdrawal instanceof Withdrawal) {

            throw new InvalidTransactionTypeException();
        }

        $this->repository->save(
            $rollback = $withdrawal->rollback()
        );

        return $rollback;
    }

    /**
     * @param DepositDTO $dto
     *
     * @return Deposit
     */
    public function deposit(DepositDTO $dto): Deposit
    {
        $transaction = new Deposit(
            $this->walletQuery->get($dto->walletId()),
            $dto->real(),
            new DepositDetails($dto->provider())
        );

        $this->repository->save($transaction);

        return $transaction;
    }

    /**
     * @param RollbackDepositDTO $dto
     *
     * @return RollbackDeposit
     */
    public function rollbackDeposit(RollbackDepositDTO $dto): RollbackDeposit
    {
        /** @var Deposit $deposit */
        $deposit = $this->repository->get($dto->depositId());

        if (!$deposit instanceof Deposit) {

            throw new InvalidTransactionTypeException();
        }

        $rollback = $deposit->rollback();

        $this->repository->save($rollback);

        return $rollback;
    }

    /**
     * @param CreateWalletDTO $dto
     * @return Wallet
     */
    public function createWallet(CreateWalletDTO $dto): Wallet
    {
        $transaction = new WalletFactory($dto->currency());

        $this->repository->save($transaction);

        return $transaction->wallet();
    }
}
