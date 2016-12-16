<?php

namespace Leos\UI\RestBundle\Controller\Security;

use Lakion\ApiTestCase\JsonApiTestCase;

/**
 * Class SecurityTest
 * 
 * @package Leos\UI\RestBundle\Controller\Security
 */
class SecurityTest extends JsonApiTestCase
{
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

        $this->expectedResponsesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/UI/Responses/Security";
        $this->dataFixturesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/UI/Fixtures";
    }

    /**
     * @group integration
     */
    public function testLoginSuccess()
    {
        $this->loadFixturesFromDirectory('user');

        $this->client->request('POST', '/auth/login.json', [
            '_username' => 'jorge',
            '_password' => 'iyoque123'
        ]);

        $response =  $this->client->getResponse();

        self::assertResponse($response, 'login_ok', 200);
    }
    
    /**
     * @group integration
     */
    public function testLoginInvalidUser()
    {
        $this->loadFixturesFromDirectory('user');

        $this->client->request('POST', '/auth/login.json', [
            '_username' => 'manolo',
            '_password' => 'qwerty'
        ]);

        $response =  $this->client->getResponse();

        self::assertEquals(401, $response->getStatusCode());
    }

    /**
     * @group integration
     */
    public function testLoginWithWrongPassword()
    {
        $this->loadFixturesFromDirectory('user');

        $this->client->request('POST', '/auth/login.json', [
            '_username' => 'jorge',
            '_password' => 'qwerty'
        ]);

        $response =  $this->client->getResponse();

        self::assertEquals(401, $response->getStatusCode());
    }

    /**
     * @group integration
     */
    public function testLoginWithMissingUsername()
    {
        $this->client->request('POST', '/auth/login.json', [
            '_password' => 'qwerty'
        ]);

        $response =  $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('username',  $response->getContent());
    }

    /**
     * @group integration
     */
    public function testLoginWithMissingPassword()
    {
        $this->client->request('POST', '/auth/login.json', [
            '_username' => 'jorge'
        ]);

        $response =  $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('password',  $response->getContent());
    }
}
