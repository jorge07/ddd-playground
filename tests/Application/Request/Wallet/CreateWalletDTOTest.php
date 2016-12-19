<?php

namespace Tests\Leos\Application\Request\Wallet;

use Leos\Application\UseCase\Transaction\Request\CreateWallet;
use Ramsey\Uuid\Uuid;


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
        $dto = new CreateWallet(Uuid::uuid4(), 'EUR');

        self::assertEquals('EUR', $dto->currency()->code());
    }

    /**
     * @group unit
     *
     * @expectedException Leos\Domain\Money\Exception\CurrencyWrongCodeException
     */
    public function testConstructWrongCurrency()
    {
        new CreateWallet(Uuid::uuid4(), 'EURAZO');
    }
}
