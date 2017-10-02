<?php

namespace Tests\Leos\Domain\Payment\ValueObject;

use Leos\Domain\Payment\Exception\InvalidProviderException;
use Leos\Domain\Payment\ValueObject\WithdrawalDetails;
use PHPUnit\Framework\TestCase;

/**
 * Class WithdrawalDetailsTest
 *
 * @package Tests\Leos\Domain\Payment\ValueObject
 */
class WithdrawalDetailsTest extends TestCase
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
     */
    public function testInvalidProvider()
    {
        self::expectException(InvalidProviderException::class);

        new WithdrawalDetails('as');
    }
}
