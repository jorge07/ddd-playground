<?php

namespace Leos\Application\UseCase\Wallet;

use Leos\Application\UseCase\Wallet\Request\GetWallet;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;

/**
 * Class GetWalletHandler
 *
 * @package Leos\Domain\Wallet\UseCase
 */
final class GetWalletHandler
{
    /**
     * @var WalletRepositoryInterface
     */
    private $repository;

    /**
     * GetWalletHandler constructor.
     * @param WalletRepositoryInterface $repository
     */
    public function __construct(WalletRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param GetWallet $request
     * @return Wallet
     */
    public function handle(GetWallet $request): Wallet
    {
        return $this->repository->get($request->uuid());
    }
}
