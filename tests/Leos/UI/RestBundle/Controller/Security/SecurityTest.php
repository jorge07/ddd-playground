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
    public function setUp()
    {
        $_SERVER['IS_DOCTRINE_ORM_SUPPORTED'] = true;
        $this->setUpClient();
        $this->setUpDatabase();
        $this->expectedResponsesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Responses/Security";
        $this->dataFixturesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Behat/Context/Fixtures";
    }

    /**
     * @group functional
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
     * @group functional
     */
    public function testLoginWrongPassword()
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
     * @group functional
     */
    public function testLoginMissingUsername()
    {
        $this->client->request('POST', '/auth/login.json', [
            '_password' => 'qwerty'
        ]);

        $response =  $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('username',  $response->getContent());
    }

    /**
     * @group functional
     */
    public function testLoginWMissingPassword()
    {
        $this->client->request('POST', '/auth/login.json', [
            '_username' => 'jorge'
        ]);

        $response =  $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('password',  $response->getContent());
    }
}
