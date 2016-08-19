<?php

namespace Leos\Application\UseCase\Wallet;

use Leos\Application\DTO\Wallet\CreditDTO;
use Leos\Application\DTO\Wallet\DebitDTO;

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

}
