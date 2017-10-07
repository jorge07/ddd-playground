<?php

namespace Tests\Leos\Domain\Payment\ValueObject;

use Leos\Domain\Payment\Exception\InvalidProviderException;
use Leos\Domain\Payment\ValueObject\DepositDetails;
use PHPUnit\Framework\TestCase;

/**
 * Class DepositDetailsTest
 * 
 * @package Tests\Leos\Domain\Payment\ValueObject
 */
class DepositDetailsTest extends TestCase
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
     */
    public function testInvalidProvider()
    {
        self::expectException(InvalidProviderException::class);

        new DepositDetails('as');
    }
}
