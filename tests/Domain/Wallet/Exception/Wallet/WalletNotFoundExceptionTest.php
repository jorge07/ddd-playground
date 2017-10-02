<?php

namespace Tests\Leos\Domain\Wallet\Exception\Wallet;

use Leos\Domain\Wallet\Exception\Wallet\WalletNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * Class WalletNotFoundExceptionTest
 *
 * @package Tests\Leos\Domain\Wallet\Exception\Wallet
 */
class WalletNotFoundExceptionTest extends TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $e = new WalletNotFoundException();

        self::assertContains('not_found', $e->getMessage());
        self::assertGreaterThan(8000, $e->getCode());
        self::assertLessThan(9000, $e->getCode());
    }
}
