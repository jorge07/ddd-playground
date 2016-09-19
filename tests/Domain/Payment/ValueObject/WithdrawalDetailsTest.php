<?php

namespace Tests\Leos\Domain\Payment\ValueObject;

use Leos\Domain\Payment\ValueObject\WithdrawalDetails;

/**
 * Class WithdrawalDetailsTest
 *
 * @package Tests\Leos\Domain\Payment\ValueObject
 */
class WithdrawalDetailsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $details = new WithdrawalDetails('paypal');

        self::assertEquals('paypal', $details->provider());
    }

    /**
     * @group unit
     *
     * @expectedException Leos\Domain\Payment\Exception\InvalidProviderException
     */
    public function testInvalidProvider()
    {
        new WithdrawalDetails('as');
    }
}
