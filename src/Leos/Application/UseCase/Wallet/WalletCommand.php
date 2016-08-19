<?php

namespace Leos\Application\UseCase\Wallet;

use Leos\Application\DTO\Wallet\CreateWalletDTO;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\Factory\WalletFactoryInterface;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;

/**
 * Class WalletCommand
 *
 * @package Leos\Domain\Wallet\UseCase
 */
final class WalletCommand
{
    /**
     * @var WalletRepositoryInterface
     */
    private $repository;

    /**
     * @var WalletFactoryInterface
     */
    private $factory;

    /**
     * WalletCommand constructor.
     *
     * @param WalletRepositoryInterface $repository
     * @param WalletFactoryInterface $factory
     */
    public function __construct(WalletRepositoryInterface $repository, WalletFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * @param CreateWalletDTO $dto
     *
     * @return Wallet
     */
    public function create(CreateWalletDTO $dto): Wallet
    {
        $wallet = $this->factory->create($dto->get());

        if ($dto->hasPersistence()) {
            $this->repository->save($wallet);
        }

        return $wallet;
    }
}
