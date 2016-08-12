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
     * @param WalletId $uid
     *
     * @throws WalletNotFoundException
     *
     * @return Wallet
     */
    public function get(WalletId $uid): Wallet;

    /**
     * @param WalletId $uid
     *
     * @return null|Wallet
     */
    public function findOneById(WalletId $uid);

    /**
     * @param Wallet $wallet
     * @return void
     */
    public function save(Wallet $wallet);

}
