<?php

namespace Leos\Application\UseCase\Wallet\Request;

use Leos\Domain\Wallet\ValueObject\WalletId;

/**
 * Class GetWallet
 *
 * @package Leos\Application\UseCase\Wallet\Request
 */
class GetWallet
{
    /**
     * @var WalletId
     */
    private $uuid;

    /**
     * GetWallet constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = new WalletId($uuid);
    }

    /**
     * @return WalletId
     */
    public function uuid(): WalletId
    {
        return $this->uuid;
    }
}