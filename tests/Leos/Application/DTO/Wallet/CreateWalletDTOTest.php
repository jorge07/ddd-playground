<?php

namespace Tests\Leos\Application\DTO\Wallet;

use Leos\Application\DTO\Wallet\CreateWalletDTO;

/**
 * Class CreateWalletDTOTest
 *
 * @package Tests\Leos\Application\DTO\Wallet
 */
class CreateWalletDTOTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $dto = new CreateWalletDTO('EUR', 100, 100);

        self::assertEquals(100, $dto->initialAmountReal()->amount());
        self::assertEquals(100, $dto->initialAmountBonus()->amount());

        self::assertEquals('EUR', $dto->currency()->code());
    }
}
