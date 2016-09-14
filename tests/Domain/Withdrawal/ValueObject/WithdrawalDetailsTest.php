<?php

namespace Tests\Leos\Domain\Withdrawal\ValueObject;

use Leos\Domain\Withdrawal\ValueObject\WithdrawalDetails;

/**
 * Class WithdrawalDetailsTest
 *
 * @package Tests\Leos\Domain\Withdrawal\ValueObject
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
}
