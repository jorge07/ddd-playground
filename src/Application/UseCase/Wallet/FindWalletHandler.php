<?php

namespace Leos\Application\UseCase\Wallet;

use Leos\Application\Request\Common\Pagination;

use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;
use Pagerfanta\Pagerfanta;

/**
 * Class FindWalletHandler
 *
 * @package Leos\Domain\Wallet\UseCase
 */
final class FindWalletHandler
{
    /**
     * @var WalletRepositoryInterface
     */
    private $repository;

    /**
     * FindWalletHandler constructor.
     * @param WalletRepositoryInterface $repository
     */
    public function __construct(WalletRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Pagination $request
     * @return Pagerfanta
     */
    public function handle(Pagination $request): Pagerfanta
    {
        return $this->repository->findAll(
            $request->getFilters(),
            $request->getOperators(),
            $request->getValues(),
            $request->getSort()
        );
    }
}
