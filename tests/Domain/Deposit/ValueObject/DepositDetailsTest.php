<?php

namespace Tests\Leos\Domain\Deposit\ValueObject;

use Leos\Domain\Deposit\ValueObject\DepositDetails;

/**
 * Class DepositDetailsTest
 * 
 * @package Tests\Leos\Domain\Deposit\ValueObject
 */
class DepositDetailsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @group unit
     */
    public function testGetters()
    {
        $details =  new DepositDetails('paypal');

        self::assertEquals('paypal', $details->provider());
    }
}
