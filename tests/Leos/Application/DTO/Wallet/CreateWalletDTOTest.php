<?php

namespace Tests\Leos\Application\DTO\Wallet;

use Leos\Application\DTO\Wallet\CreateWalletDTO;

class CreateWalletDTOTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $dto = new CreateWalletDTO(100, 100);

        self::assertEquals(
            [
                'real' => [
                    'amount'=> 100
                ],
                'bonus' => [
                    'amount'=> 100
                ]
            ],
            $dto->get()
        );

        self::assertTrue($dto->hasPersistence());
    }
}
