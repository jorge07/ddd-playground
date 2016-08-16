<?php

namespace Tests\Leos\UI\RestBundle\Controller\Wallet;

use Lakion\ApiTestCase\JsonApiTestCase;

/**
 * Class WalletControllerTest
 * 
 * @package Leos\UI\RestBundle\Controller\Wallet
 */
class WalletControllerTest extends JsonApiTestCase
{
    public function setUp()
    {
        $this->setUpClient();
        $this->expectedResponsesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Responses/Wallet";
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
            'real' => 99999
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
     * @group functional
     */
    public function testCreditAction()
    {
        $this->client->request('POST', '/api/v1/wallet.json');

        $response = $this->client->getResponse();

        $this->client->request('POST', $response->headers->get('location') . '/credit.json', [
            'real' => 100
        ]);

        self::assertResponse($this->client->getResponse(), "credit", 202);
    }

    /**
     * @group functional
     */
    public function testCredit404Action()
    {
        $this->client->request('POST',  '/api/wallet/404/credit.json', [
            'real' => 5,
            'bonus' => 5
        ]);

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group functional
     */
    public function testDebitAction()
    {
        $this->client->request('POST', '/api/v1/wallet.json', [
            'real' => 5000,
            'bonus' => 2500,
        ]);

        $response = $this->client->getResponse();

        $this->client->request('POST', $response->headers->get('location') . '/debit.json', [
            'real' => 5,
            'bonus' => 5
        ]);

        self::assertResponse($this->client->getResponse(), "debit", 202);
    }
    /**
     * @group functional
     */
    public function testDebit409Action()
    {
        $this->client->request('POST', '/api/v1/wallet.json', [
            'real' => 5000,
            'bonus' => 2500,
        ]);

        $response = $this->client->getResponse();

        $this->client->request('POST', $response->headers->get('location') . '/debit.json', [
            'real' => 60,
            'bonus' => 5
        ]);

        self::assertEquals(409, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group functional
     */
    public function testDebit404Action()
    {
        $this->client->request('POST',  '/api/wallet/404/debit.json', [
            'real' => 5,
            'bonus' => 5
        ]);

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @param string $location
     * @param string $responseFile
     * @param int $code
     */
    private function redirect(string $location, string $responseFile, int $code)
    {
        $this->client->request('GET', $location);

        self::assertResponse($this->client->getResponse(), $responseFile, $code);
    }
}
