<?php

namespace Tests\Leos\Application\UseCase\Transaction;

use Lakion\ApiTestCase\JsonApiTestCase;
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
class TransactionCommandTest extends JsonApiTestCase
{
    private $fixture = [];

    public function setUp()
    {
        $this->setUpClient();

        $repo = self::getMockBuilder(TransactionRepositoryInterface::class)
            ->setMethods(['save', 'get'])->getMock();

        $userRepo = self::getMockBuilder(UserRepositoryInterface::class)
            ->setMethods(['save', 'getOneByUuid', 'findOneByUuid', 'findOneByUsername']);

        $mock = $userRepo->getMock();

        $this->fixture['user'] = UserTest::create();

        $mock->method('findOneByUuid')->with((string) $this->fixture['user']->uuid())->willReturn($this->fixture['user']);

        $walletRepo = self::getMockBuilder(WalletRepositoryInterface::class)
            ->setMethods(['save', 'get', 'findOneById', 'findAll'])->getMock();

        $container = $this->client->getContainer();

        $container->set('Leos\Domain\Wallet\Repository\WalletRepositoryInterface', $walletRepo);
        $container->set('Leos\Domain\Transaction\Repository\TransactionRepositoryInterface', $repo);
        $container->set('Leos\Domain\User\Repository\UserRepositoryInterface', $mock);
    }

    /**
     * @group functional
     */
    public function testShouldCreateTransactionWithNewWallet()
    {
        /** @var User $user */
        $user = $this->fixture['user'];
        $result = $this->get('tactician.commandbus')->handle(new CreateWallet((string) $user->uuid(), 'EUR'));

        self::assertInstanceOf(Wallet::class, $result);
        self::assertTrue($result->user()->uuid()->equals($user->uuid()));
        self::assertEquals(0, $result->real()->amount());
        self::assertEquals(0, $result->bonus()->amount());
    }
}