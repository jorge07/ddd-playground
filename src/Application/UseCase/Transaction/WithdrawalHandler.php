<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Wallet\GetWalletHandler;
use Leos\Application\UseCase\Wallet\Request\GetWallet;
use Leos\Application\UseCase\Transaction\Request\Withdrawal as WithdrawalRequest;

use Leos\Domain\Payment\Model\Withdrawal;
use Leos\Domain\Payment\ValueObject\WithdrawalDetails;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\Transaction\Exception\InvalidTransactionTypeException;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

/**
 * Class WithdrawalHandler
 *
 * @package Leos\Application\UseCase\Transaction
 */
class WithdrawalHandler
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $repository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var GetWalletHandler
     */
    private $walletQuery;

    /**
     * Withdrawal constructor.
     * @param TransactionRepositoryInterface $repository
     * @param UserRepositoryInterface $userRepository
     * @param GetWalletHandler $walletQuery
     */
    public function __construct(
        TransactionRepositoryInterface $repository,
        UserRepositoryInterface $userRepository,
        GetWalletHandler $walletQuery)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->walletQuery = $walletQuery;
    }

    /**
     * @param WithdrawalRequest $request
     * @return Withdrawal
     * @throws InvalidTransactionTypeException
     */
    public function handle(WithdrawalRequest $request): Withdrawal
    {
        $wallet = $this->walletQuery->handle(new GetWallet($request->walletId()));

        $transaction = Withdrawal::create(
            $wallet,
            $request->real(),
            new WithdrawalDetails($request->provider())
        );

        $this->repository->save($transaction);

        return $transaction;
    }
}
