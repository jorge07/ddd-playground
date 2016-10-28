<?php

namespace Tests\Leos\Domain\Wallet\Model;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\ValueObject\Credit;
use Leos\Domain\Wallet\ValueObject\WalletId;
use Leos\Domain\Wallet\Exception\Credit\CreditNotEnoughException;

use Leos\Domain\Money\ValueObject\Money;
use Leos\Domain\Money\ValueObject\Currency;
use Tests\Leos\Domain\User\Model\UserTest;

/**
 * Class WalletTest
 *
 * @package Leos\Domain\Wallet\Model
 */
class WalletTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @group unit
     */
    public function testWalletGetters()
    {
        $wallet = self::create();

        $real = new Credit(100);
        $bonus = new Credit(100);

        $currency = $this->getTestCurrency();

        $wallet->addRealMoney($real->toMoney($currency));
        $wallet->addBonusMoney($bonus->toMoney($currency));

        self::assertEquals(100, $wallet->real()->amount());
        self::assertEquals(100, $wallet->bonus()->amount());
        self::assertNotNull($wallet->createdAt());
        self::assertNull($wallet->updatedAt());
        self::assertInstanceOf(WalletId::class, $wallet->walletId());
        self::assertNotNull($wallet->id());
        self::assertNotNull($wallet->walletId()->__toString());
        self::assertNotNull($wallet->user());
    }

    /**
     * @group unit
     */
    public function testWalletAddCredit()
    {
        $wallet = self::create();

        $real = new Credit(100);
        $bonus = new Credit(100);

        $currency = $this->getTestCurrency();

        $wallet->addRealMoney($real->toMoney($currency));
        $wallet->addBonusMoney($bonus->toMoney($currency));
        $wallet->addRealMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->real());
        self::assertFalse($real->equals($wallet->real()));

        self::assertEquals(350, $wallet->real()->amount());

        $wallet->addBonusMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->bonus());
        self::assertFalse($real->equals($wallet->bonus()));

        self::assertEquals(350, $wallet->bonus()->amount());
    }

    /**
     * @group unit
     */
    public function testWalletRemoveCredit()
    {
        $wallet = self::create();

        $real = new Credit(350);
        $bonus = new Credit(350);

        $currency = $this->getTestCurrency();

        $wallet->addRealMoney($real->toMoney($currency));
        $wallet->addBonusMoney($bonus->toMoney($currency));

        $wallet->removeRealMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->real());
        self::assertFalse($real->equals($wallet->real()));

        self::assertEquals(100, $wallet->real()->amount());

        $wallet->removeBonusMoney(new Money(2.50, $this->getTestCurrency()));

        self::assertNotSame($real, $wallet->bonus());
        self::assertFalse($real->equals($wallet->bonus()));

        self::assertEquals(100, $wallet->bonus()->amount());
    }

    /**
     * @group unit
     */
    public function testWalletFailWhenRemoveWithNotEnoughCredit()
    {
        try {

            $wallet = self::create();

            $real = new Credit(350);
            $bonus = new Credit(350);
            $currency = $this->getTestCurrency();

            $wallet->addRealMoney($real->toMoney($currency));
            $wallet->addBonusMoney($bonus->toMoney($currency));

            $wallet->removeRealMoney(new Money(8.50, $this->getTestCurrency()));

            self::assertEquals(true, false, "Remove money with not enough credit should throw an exception");

        } catch (\Exception $e) {

            self::assertGreaterThan(4000, $e->getCode());
            self::assertInstanceOf(CreditNotEnoughException::class, $e);
        }
    }

    /**
     * @return Currency
     */
    private function getTestCurrency(): Currency
    {
        return new Currency('EUR', 1);
    }

    public static function create(): Wallet
    {
        return new Wallet(UserTest::create());
    }
}
