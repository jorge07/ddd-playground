<?php

namespace Tests\Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Transaction\Request\CreateWalletDTO;
use Leos\Application\UseCase\Transaction\TransactionCommand;
use Leos\Application\UseCase\Wallet\WalletQuery;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Leos\Domain\User\Repository\UserRepositoryInterface;
use Leos\Domain\User\ValueObject\UserId;
use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;
use Tests\Leos\Domain\User\Model\UserTest;

/**
 * Class TransactionCommandTest
 */
class TransactionCommandTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @var TransactionCommand
     */
    private $command;

    public function setUp()
    {
        $repo = self::getMockBuilder(TransactionRepositoryInterface::class)
            ->setMethods(['save', 'get'])->getMock();

        $userRepo = self::getMockBuilder(UserRepositoryInterface::class)
            ->setMethods(['save', 'findById', 'findByUsername']);

        $mock = $userRepo->getMock();
        $mock->method('findById')->willReturn(UserTest::create());

        $walletRepo = self::getMockBuilder(WalletRepositoryInterface::class)
            ->setMethods(['save', 'get', 'findOneById', 'findAll'])->getMock();

        $this->command = new TransactionCommand(
            $repo,
            $mock,
            new WalletQuery($walletRepo)
        );
    }

    public function tearDown()
    {
        unset($this->command);
    }

    /**
     * @group unit
     */
    public function testShouldCreateTransactionWithNewWallet()
    {
        $user = new UserId();

        $result = $this->command->createWallet(new CreateWalletDTO($user->__toString(), 'EUR'));

        self::assertInstanceOf(Wallet::class, $result);
        self::assertEquals(0, $result->user()->id()->equals($user));
        self::assertEquals(0, $result->real()->amount());
        self::assertEquals(0, $result->bonus()->amount());
    }

    public static function randomId(): string
    {
        return (new UserId())->__toString();
    }
}