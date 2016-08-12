<?php

namespace Leos\Domain\Wallet\UseCase;

use Leos\Domain\Money\ValueObject\Money;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Factory\WalletFactoryInterface;
use Leos\Infrastructure\WalletBundle\DTO\CreateWalletDTO;
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
     * @param bool $persist
     *
     * @return Wallet
     */
    public function create(CreateWalletDTO $dto, bool $persist = true): Wallet
    {
        $wallet = $this->factory->create($dto->get());

        if ($persist) {
            $this->repository->save($wallet);
        }

        return $wallet;
    }

    /**
     * @param WalletId $uid
     * @param Money $money
     *
     * @return WalletManager
     */
    public function debitReal(WalletId $uid, Money $money): self
    {
        return $this->repository->get($uid)->removeRealMoney($money);

    }

    /**
     * @param WalletId $uid
     * @param Money $money
     *
     * @return WalletManager
     */
    public function debitBonus(WalletId $uid, Money $money): self
    {
        return $this->repository->get($uid)->removeBonusMoney($money);

    }

    /**
     * @param WalletId $uid
     * @param Money $money
     * @return WalletManager
     */
    public function creditReal(WalletId $uid, Money $money): self
    {
        return $this->repository->get($uid)->addRealMoney($money);
    }

    /**
     * @param WalletId $uid
     * @param Money $money
     * @return WalletManager
     */
    public function creditBonus(WalletId $uid, Money $money): self
    {
        return $this->repository->get($uid)->addBonusMoney($money);
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
