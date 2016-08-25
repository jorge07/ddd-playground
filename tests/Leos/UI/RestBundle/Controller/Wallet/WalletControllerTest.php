<?php

namespace Tests\Leos\UI\RestBundle\Controller\Wallet;

use Lakion\ApiTestCase\JsonApiTestCase;
use Tests\Leos\UI\RestBundle\Controller\Security\SecurityTrait;

/**
 * Class WalletControllerTest
 * 
 * @package Leos\UI\RestBundle\Controller\Wallet
 */
class WalletControllerTest extends JsonApiTestCase
{
    use SecurityTrait;

    private $databaseLoaded = false;

    public function setUp()
    {
        $_SERVER['IS_DOCTRINE_ORM_SUPPORTED'] = true;

        if (!$this->client) {

            $this->setUpClient();
        }

        if (!$this->databaseLoaded) {

            $this->setUpDatabase();
            $this->databaseLoaded = true;
        }

        $this->expectedResponsesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Responses/Wallet";
        $this->dataFixturesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Behat/Context/Fixtures";
    }

    /**
     * @group functional
     */
    public function testCreateWalletAction()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/wallet.json');

        $response = $this->client->getResponse();

        self::assertEquals($response->getStatusCode(), 201);

        $this->redirect($response->headers->get('Location'), 'get_wallet', 200);
    }

    /**
     * @group functional
     */
    public function testCreateWalletWithWrongCurrencyAction()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/wallet.json', [
            'real' => 50,
            'bonus' => 25,
            'currency' => 'EURAZO'
        ]);

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
        self::assertContains('currency', $this->client->getResponse()->getContent());
    }

    /**
     * @group functional
     */
    public function testGetWalletActionNotFound()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('GET', '/api/v1/wallet/0.json');

        self::assertEquals($this->client->getResponse()->getStatusCode(), 404);
    }

    /**
     * @group functional
     */
    public function testCreditAction()
    {
        $this->loginClient('jorge', 'iyoque123');

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
    public function testCredit400Action()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST',  '/api/v1/wallet/404/credit.json', [
            'real' => 5,
            'bonus' => 5
        ]);


        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group functional
     */
    public function testCredit400WrongCurrencyAction()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST',  '/api/v1/wallet/0cb00000-646e-11e6-a5a2-0000ac1b0000/credit.json', [
            'real' => 5,
            'bonus' => 5,
            'currency' => 'LIBRAS'
        ]);

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
        self::assertContains('currency', $this->client->getResponse()->getContent());
    }

    /**
     * @group functional
     */
    public function testDebitAction()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/wallet.json', [
            'real' => 50,
            'bonus' => 25,
            'currency' => 'EUR'
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
    public function testDebit400WrongCurrencyAction()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST',  '/api/v1/wallet/0cb00000-646e-11e6-a5a2-0000ac1b0000/debit.json', [
            'real' => 5,
            'bonus' => 5,
            'currency' => 'LIBRAS'
        ]);

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
        self::assertContains('currency', $this->client->getResponse()->getContent());
    }

    /**
     * @group functional
     */
    public function testDebit409Action()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/wallet.json', [
            'real' => 50,
            'bonus' => 25,
            'currency' => 'EUR'
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
    public function testDebit400Action()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST',  '/api/v1/wallet/404/debit.json', [
            'real' => 5,
            'bonus' => 5
        ]);

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group functional
     */
    public function testDebit404Action()
    {
        $this->loginClient('jorge', 'iyoque123');
        
        $this->client->request('POST',  '/api/v1/wallet/0cb00000-646e-11e6-a5a2-0000ac1b0000/debit.json', [
            'real' => 5,
            'bonus' => 5
        ]);

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group functional
     */
    public function testCredit404Action()
    {
        $this->loginClient('jorge', 'iyoque123');
        
        $this->client->request('POST',  '/api/v1/wallet/0cb00000-646e-11e6-a5a2-0000ac1b0000/credit.json', [
            'real' => 5,
            'bonus' => 5
        ]);

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @group functional
     */
    public function testWalletCollectionAction()
    {
        $this->loginClient('jorge', 'iyoque123');
        
        $this->loadFixturesFromDirectory('wallet');

        $this->client->request('GET',  '/api/v1/wallet.json');

        self::assertResponse($this->client->getResponse(), "cget_wallet", 200);
    }

    /**
     * @group functional
     */
    public function testWalletCollectionFilterAction()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->loadFixturesFromDirectory('wallet');
        $this->client->request('GET',  '/api/v1/wallet.json?filterParam[]=real.amount&filterOp[]=eq&filterValue[]=50');

        self::assertResponse($this->client->getResponse(), "cget_wallet_filter_50", 200);
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
