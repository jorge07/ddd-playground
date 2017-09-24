<?php

namespace Tests\Leos\Application\UseCase\Transaction;

use Leos\Application\UseCase\Transaction\CreateWalletHandler;
use Leos\Application\UseCase\Transaction\Request\CreateWallet;
use Leos\Domain\Transaction\Repository\TransactionRepositoryInterface;
use Leos\Domain\User\Model\User;
use Leos\Domain\User\Repository\UserRepositoryInterface;

use Leos\Domain\Wallet\Model\Wallet;
use Leos\Domain\Wallet\Repository\WalletRepositoryInterface;
use Tests\Leos\Domain\User\Model\UserTest;

/**
 * Class TransactionCommandTest
 */
class TransactionCommandTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @var CreateWalletHandler
     */
    private $command;

    private $fixture = [];

    public function setUp()
    {
        $repo = self::getMockBuilder(TransactionRepositoryInterface::class)
            ->setMethods(['save', 'get'])->getMock();

        $userRepo = self::getMockBuilder(UserRepositoryInterface::class)
            ->setMethods(['save', 'getOneByUuid', 'findOneByUuid', 'findOneByUsername']);

        $mock = $userRepo->getMock();

        $this->fixture['user'] = UserTest::create();
        $mock->method('findOneByUuid')->with((string) $this->fixture['user']->uuid())->willReturn($this->fixture['user']);

        $walletRepo = self::getMockBuilder(WalletRepositoryInterface::class)
            ->setMethods(['save', 'get', 'findOneById', 'findAll'])->getMock();

        $this->command = new CreateWalletHandler(
            $repo,
            $mock
        );
    }

    public function tearDown()
    {
        unset($this->command);
    }

    /**
     * @group functional
     */
    public function testShouldCreateTransactionWithNewWallet()
    {
        /** @var User $user */
        $user = $this->fixture['user'];
        $result = $this->command->handle(new CreateWallet((string) $user->uuid(), 'EUR'));

        self::assertInstanceOf(Wallet::class, $result);
        self::assertTrue($result->user()->uuid()->equals($user->uuid()));
        self::assertEquals(0, $result->real()->amount());
        self::assertEquals(0, $result->bonus()->amount());
    }
}