<?php

namespace Tests\Leos\Domain\Wallet\ValueObject;

use Leos\Domain\Wallet\ValueObject\Credit;

/**
 * Class CreditTest
 * @package Leos\Domain\Wallet\Model
 */
class CreditTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testCreditGetters()
    {
        $credit = new Credit(100);

        self::assertEquals(100, $credit->amount());
        self::assertEquals(100, (string) $credit);
        self::assertNotNull($credit->generatedAt());
    }
}
