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
     * @group functional
     */
    public function testPostWalletAction()
    {
        $this->client->request('POST', '/api/v1/wallet.json');

        $response = $this->client->getResponse();

        self::assertEquals($response->getStatusCode(), 201);

        $this->redirect($response->headers->get('Location'), 'get_wallet', 200);
    }

    /**
     * @group functional
     */
    public function testPostWalletErrorAction()
    {
        $this->client->request('POST', '/api/v1/wallet.json', [
            'real' => 9999
        ]);

        $response = $this->client->getResponse();

        self::assertEquals($response->getStatusCode(), 400);
    }
    /**
     * @group functional
     */
    public function testGetWalletActionNotFound()
    {
        $this->client->request('GET', '/api/v1/wallet/0.json');

        self::assertEquals($this->client->getResponse()->getStatusCode(), 404);
    }

    /**
     * @param string $location
     * @param string $responseFile
     * @param int $code
     */
    private function redirect(string $location, string $responseFile, int $code)
    {
        $this->client->request('GET', $location);

        self::assertResponse($response = $this->client->getResponse(), $responseFile, $code);
    }
}
