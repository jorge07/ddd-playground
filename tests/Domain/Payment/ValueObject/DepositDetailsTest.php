<?php

namespace Tests\Leos\Domain\Payment\ValueObject;

use Leos\Domain\Payment\ValueObject\DepositDetails;

/**
 * Class DepositDetailsTest
 * 
 * @package Tests\Leos\Domain\Payment\ValueObject
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


    /**
     * @group unit
     *
     * @expectedException Leos\Domain\Payment\Exception\InvalidProviderException
     */
    public function testInvalidProvider()
    {
        new DepositDetails('as');
    }
}
