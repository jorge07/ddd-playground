<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Transaction\Request\CreateDeposit;

use Leos\Application\UseCase\Wallet\GetWalletHandler;
use Leos\Application\UseCase\Wallet\Request\GetWallet;

use Leos\Domain\Payment\Model\Deposit;
use Leos\Domain\Payment\ValueObject\DepositDetails;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

/**
 * Class CreateDepositHandler
 *
 * @package Leos\Application\UseCase\Transaction
 */
class CreateDepositHandler
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
     * @param CreateDeposit $request
     *
     * @return Deposit
     */
    public function handle(CreateDeposit $request): Deposit
    {
        $wallet = $this->walletQuery->handle(new GetWallet($request->walletId()));

        $transaction = Deposit::create(
            $wallet,
            $request->real(),
            new DepositDetails($request->provider())
        );

        $this->repository->save($transaction);

        return $transaction;
    }
}
