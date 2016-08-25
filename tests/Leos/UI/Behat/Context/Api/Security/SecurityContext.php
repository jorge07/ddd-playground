<?php

namespace Tests\Leos\UI\Behat\Context\Api\Security;

use Tests\Leos\UI\Behat\Context\Api\ApiContext;

/**
 * Class SecurityContext
 *
 * @package Tests\Leos\UI\Behat\Context\Api\Security
 */
class SecurityContext extends ApiContext
{
    /**
     * @Given /^a list of users persisted$/
     */
    public function aListOfWalletsPersisted()
    {
        static::createSharedKernel();
        $this->setUpDatabase();
        $this->loadFixturesFromDirectory('user');
    }
}
