<?php

namespace Tests\Leos\Domain\Common\ValueObject;

use Leos\Domain\User\ValueObject\UserId;

/**
 * Class AggregateRootIdTest
 *
 * @package Leos\Domain\Common\ValueObject
 */
class AggregateRootIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testEquals()
    {
        $uuid = new UserId();
        $uuid2 = new UserId();
        $uuid3 = new UserId((string) $uuid);

        self::assertTrue($uuid->equals($uuid3));
        self::assertFalse($uuid->equals($uuid2));
    }

    /**
     * @group unit
     *
     * @expectedException Leos\Domain\Common\Exception\InvalidUUIDException
     */
    public function testWrongUUId()
    {
        new UserId(21);
    }
}
