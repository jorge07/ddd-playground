<?php

namespace Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Transaction\Request\RollbackDeposit as RollbackDepositRequest;

use Leos\Domain\Payment\Model\Deposit;
use Leos\Domain\Payment\Model\RollbackDeposit;
use Leos\Domain\Transaction\Exception\InvalidTransactionTypeException;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;

/**
 * Class RollbackDepositHandler
 *
 * @package Leos\Application\UseCase\Transaction
 */
class RollbackDepositHandler
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
     * @param RollbackDepositRequest $request
     * @return RollbackDeposit
     * @throws InvalidTransactionTypeException
     */
    public function handle(RollbackDepositRequest $request): RollbackDeposit
    {
        /** @var Deposit $deposit */
        $deposit = $this->repository->get($request->depositId());

        if (!$deposit instanceof Deposit) {

            throw new InvalidTransactionTypeException();
        }

        $rollback = $deposit->rollback();

        $this->repository->save($rollback);

        return $rollback;
    }
}
