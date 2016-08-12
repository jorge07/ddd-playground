<?php
declare(strict_types=1);

namespace Leos\Domain\Wallet\Factory;

use Leos\Domain\Wallet\Model\Wallet;

/**
 * Interface WalletFactoryInterface
 *
 * @package Leos\Domain\Wallet\Factory
 */
interface WalletFactoryInterface
{
    /**
     * @param array $data
     * @return Wallet
     */
    public function create(array $data): Wallet;
}
