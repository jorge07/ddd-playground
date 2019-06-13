<?php

namespace Leos\Domain\Wallet\ValueObject;

use Leos\Domain\Common\AggregateRootId;

/**
 * Class WalletId
 * @package Leos\Domain\Wallet\ValueObject
 */
class WalletId extends AggregateRootId
{
    /**
     * @var string
     */
    protected $uuid;
}
