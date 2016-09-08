<?php

namespace Leos\Domain\Wallet\Exception\Wallet;

/**
 * Class WalletNotFoundException
 * 
 * @package Leos\Domain\Wallet\Exception\Wallet
 */
class WalletNotFoundException extends \Exception
{
    /**
     * WalletNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('wallet.exception.not_found', 8004);
    }
}
