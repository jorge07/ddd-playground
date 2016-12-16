<?php

namespace Leos\Application\UseCase\Transaction\Request;

use Leos\Domain\User\ValueObject\UserId;
use Leos\Domain\Money\ValueObject\Currency;

/**
 * Class CreateWallet
 * 
 * @package Leos\Application\UseCase\Transaction\Request
 */
class CreateWallet
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var Currency
     */
    private $currency;

    /**
     * @param string $userId
     * @param string $currency
     */
    public function __construct(string $userId, string $currency = Currency::DEFAULT)
    {
        $this->userId = new UserId($userId);
        $this->currency = new Currency($currency);
    }

    /**
     * @return UserId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return Currency
     */
    public function currency(): Currency
    {
       return $this->currency;
    }

}
