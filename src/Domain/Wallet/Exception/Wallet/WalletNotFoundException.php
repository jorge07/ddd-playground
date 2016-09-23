<?php

namespace Leos\Domain\Wallet\Exception\Wallet;

use Leos\Domain\Common\Exception\NotFoundException;

/**
 * Class WalletNotFoundException
 * 
 * @package Leos\Domain\Wallet\Exception\Wallet
 */
class WalletNotFoundException extends NotFoundException
{
    /**
     * WalletNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('wallet.exception.not_found', 8004);
    }
}
