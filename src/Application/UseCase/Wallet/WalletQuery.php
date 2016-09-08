<?php

namespace Leos\Application\UseCase\Wallet;

use Leos\Application\Request\Common\PaginationDTO;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;
use Pagerfanta\Pagerfanta;

/**
 * Class WalletQuery
 *
 * @package Leos\Domain\Wallet\UseCase
 */
final class WalletQuery
{
    /**
     * @var WalletRepositoryInterface
     */
    private $repository;

    /**
     * WalletQuery constructor.
     * @param WalletRepositoryInterface $repository
     */
    public function __construct(WalletRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param WalletId $uid
     * @return Wallet
     */
    public function get(WalletId $uid): Wallet
    {
        return $this->repository->get($uid);
    }

    /**
     * @param PaginationDTO $dto
     * @return Pagerfanta
     */
    public function find(PaginationDTO $dto): Pagerfanta
    {
        return $this->repository->findAll($dto->getFilters(), $dto->getOperators(), $dto->getValues(), $dto->getSort());
    }
}
