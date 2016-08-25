<?php

namespace Tests\Leos\UI\Behat\Context\Api\Wallet;

use Tests\Leos\UI\Behat\Context\Api\ApiContext;

class WalletContext extends ApiContext
{

    /**
     * @Given /^a list of wallets persisted$/
     */
    public function aListOfWalletsPersisted()
    {
        static::createSharedKernel();
        $this->setUpDatabase();
        $this->loadFixturesFromDirectory('wallet');
        $this->loadFixturesFromDirectory('user');
    }

}
