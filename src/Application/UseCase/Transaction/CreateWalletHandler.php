<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Transaction\Request\CreateWallet;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\Factory\WalletFactory;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

/**
 * Class CreateWalletHandler
 *
 * @package Leos\Application\UseCase\Transaction
 */
class CreateWalletHandler
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
     * Withdrawal constructor.
     * @param TransactionRepositoryInterface $repository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        TransactionRepositoryInterface $repository,
        UserRepositoryInterface $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param CreateWallet $request
     * @return Wallet
     */
    public function handle(CreateWallet $request): Wallet
    {
        $transaction = new WalletFactory(
            $this->userRepository->findOneByUuid($request->userId()),
            $request->currency()
        );

        $this->repository->save($transaction);

        return $transaction->wallet();
    }
}
