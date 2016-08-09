<?php

namespace Leos\Domain\Wallet\Model;

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

        self::assertEquals(100, $credit->getAmount());
        self::assertNotNull($credit->getCreatedAt());
    }
}
