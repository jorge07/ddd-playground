<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Transaction\Request\RollbackWithdrawal as RollbackWithdrawalRequest;

use Leos\Domain\Payment\Model\Withdrawal;
use Leos\Domain\Payment\Model\RollbackWithdrawal;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\Transaction\Exception\TransactionNotFoundException;
use Leos\Domain\Transaction\Exception\InvalidTransactionTypeException;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

/**
 * Class RollbackWithdrawalHandler
 *
 * @package Leos\Application\UseCase\Wallet
 */
class RollbackWithdrawalHandler
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
     * @param RollbackWithdrawalRequest $request
     *
     * @return RollbackWithdrawal
     *
     * @throws InvalidTransactionTypeException
     * @throws TransactionNotFoundException
     */
    public function handle(RollbackWithdrawalRequest $request): RollbackWithdrawal
    {
        $withdrawal = $this->repository->get($request->withdrawalId());

        if (!$withdrawal instanceof Withdrawal) {

            throw new InvalidTransactionTypeException();
        }

        $this->repository->save(
            $rollback = $withdrawal->rollback()
        );

        return $rollback;
    }

}
