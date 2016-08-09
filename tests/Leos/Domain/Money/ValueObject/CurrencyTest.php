<?php

namespace Tests\Leos\Domain\Money\ValueObject;

use Leos\Domain\Money\ValueObject\Currency;
use Leos\Domain\Money\Exception\CurrencyWrongCodeException;

/**
 * Class CurrencyTest
 *
 * @package Tests\Leos\Domain\Money\ValueObject
 */
class CurrencyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testCurrencyBadCode()
    {
        try{
            
            new Currency('EURO', 3);

        } catch (CurrencyWrongCodeException $e) {
            
            self::assertGreaterThan(5000, $e->getCode());
        }
    }

    /**
     * @group unit
     */
    public function testCurrencyGetters()
    {
        $currency = new Currency('EUR', 1);

        self::assertEquals('EUR', $currency->getCode());
        self::assertEquals(1, $currency->getExchange());
    }

    /**
     * @group unit
     */
    public function testCurrencyEqual()
    {
        $currency = new Currency('EUR', 1);
        $currency2 = new Currency('EUR', 1);
        $currency3 = new Currency('EUR', 3);
        $currency4 = new Currency('GBP', 8);

        self::assertTrue($currency->equals($currency2));
        self::assertFalse($currency->equals($currency3));
        self::assertFalse($currency->equals($currency4));
    }

}
