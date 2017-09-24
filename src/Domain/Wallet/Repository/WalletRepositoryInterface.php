<?php

namespace Leos\Domain\Wallet\Repository;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;

/**
 * Interface WalletRepositoryInterface
 *
 * @package Leos\Domain\Wallet\Repository
 */
interface WalletRepositoryInterface
{
    /**
     * @param array $keys
     * @param array $operators
     * @param array $values
     * @param array $sort
     *
     * @return Wallet[]|\Pagerfanta\Pagerfanta
     */
    public function findAll(array $keys = [], array $operators = [], array $values = [], array $sort = []);

    /**
     * @param WalletId $uid
     *
     * @throws WalletNotFoundException
     *
     * @return Wallet
     */
    public function get(WalletId $uid): Wallet;

    public function findOneById(WalletId $uid): ?Wallet;

}
