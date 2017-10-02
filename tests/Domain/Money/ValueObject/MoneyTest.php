<?php

namespace Tests\Leos\Domain\Money\ValueObject;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use PHPUnit\Framework\TestCase;

/**
 * Class MoneyTest
 * @package Tests\Leos\Domain\Money\ValueObject
 */
class MoneyTest extends TestCase
{
    /**
     * @group unit
     */
    public function testMoneyGetters()
    {
        $money = new Money(100, $currency = new Currency('EUR', 1));

        self::assertEquals(100, $money->amount());
        self::assertEquals($currency, $money->currency());
    }
}
