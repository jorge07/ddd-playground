<?php

namespace Tests\Leos\UI\Behat\Context\Api\Wallet;

use GuzzleHttp\RequestOptions;
use Leos\Domain\User\Model\User;
use Tests\Leos\UI\Behat\Context\Api\ApiContext;

/**
 * Class WalletContext
 * 
 * @package Tests\Leos\UI\Behat\Context\Api\Wallet
 */
class WalletContext extends ApiContext
{
    /**
     * @var string
     */
    private $transaction;

    /**
     * @Given /^a list of wallets persisted$/
     */
    public function aListOfWalletsPersisted()
    {
        $this->createSharedKernel('dev');
        $this->setUpDatabase();
        /** @var User[] $fixtures */
        $fixtures = $this->loadFixturesFromDirectory('wallet');

        $this->addPlaceHolder('userId', $fixtures['jorge']->id()->__toString());
    }

    /**
     * @Then /^I rollback the deposit$/
     */
    public function iRollbackTheDeposit()
    {
        $this->request('POST', '/api/v1/rollback/deposit.json', [
            RequestOptions::JSON => [
                'deposit' => $this->transaction
            ]
        ]);
    }

    /**
     * @Then /^I rollback the withdrawal/
     */
    public function iRollbackTheWithdrawal()
    {
        $this->request('POST', '/api/v1/rollback/withdrawal.json', [
            RequestOptions::JSON => [
                'withdrawal' => $this->transaction
            ]
        ]);
    }

    /**
     * @Given /^I store the transaction$/
     */
    public function iStoreTheTransaction()
    {
        $this->transaction = json_decode((string) $this->response->getBody(), true)['id'];
    }

}
