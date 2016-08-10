<?php

namespace Leos\Domain\Money\ValueObject;

/**
 * Class MoneyTest
 * @package Leos\Domain\Money\ValueObject
 */
class MoneyTest extends \PHPUnit_Framework_TestCase
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
