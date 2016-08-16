<?php

namespace Leos\Application\UseCase\Wallet;

use Leos\Application\DTO\Wallet\DebitDTO;
use Leos\Application\DTO\Wallet\CreditDTO;
use Leos\Application\DTO\Wallet\CreateWalletDTO;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Factory\WalletFactoryInterface;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;

/**
 * Class WalletManager
 *
 * @package Leos\Domain\Wallet\UseCase
 */
final class WalletManager
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
     * WalletManager constructor.
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

    /**
     * @param DebitDTO $dto
     * @return Wallet
     */
    public function debit(DebitDTO $dto): Wallet
    {
        $wallet = $this->get($dto->walletId())
            ->removeRealMoney($dto->real())
            ->removeBonusMoney($dto->bonus())
        ;

        $this->repository->save($wallet);

        return $wallet;
    }

    /**
     * @param CreditDTO $dto
     * @return Wallet
     */
    public function credit(CreditDTO $dto): Wallet
    {
        $wallet = $this->get($dto->walletId())
            ->addRealMoney($dto->real())
            ->addBonusMoney($dto->bonus())
        ;

        $this->repository->save($wallet);

        return $wallet;
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
     * @param WalletId $uid
     *
     * @return null|WalletId
     */
    public function findOne(WalletId $uid)
    {
        return $this->repository->findOneById($uid);
    }
}
