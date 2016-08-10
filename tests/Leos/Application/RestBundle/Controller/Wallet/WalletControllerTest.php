<?php

namespace Leos\Application\RestBundle\Controller\Wallet;

use Lakion\ApiTestCase\JsonApiTestCase;

/**
 * Class WalletControllerTest
 * 
 * @package Leos\Application\RestBundle\Controller\Wallet
 */
class WalletControllerTest extends JsonApiTestCase
{
    public function setUp()
    {
        $this->setUpClient();
        $this->expectedResponsesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/Application/RestBundle/Response/Wallet";
    }

    /**
     * @group unit
     */
    public function testPingAction()
    {
        $this->client->request('POST', '/api/v1/wallet.json');

        self::assertResponse($this->client->getResponse(), "post_wallet");
    }
}
