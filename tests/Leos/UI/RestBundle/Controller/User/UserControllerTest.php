<?php

namespace Tests\Leos\UI\RestBundle\Controller\User;

use Lakion\ApiTestCase\JsonApiTestCase;
use Tests\Leos\UI\RestBundle\Controller\Security\SecurityTrait;

/**
 * Class UserControllerTest
 *
 * @package Leos\UI\RestBundle\Controller\User
 */
class UserControllerTest extends JsonApiTestCase
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

        $this->expectedResponsesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Responses/User";
        $this->dataFixturesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Behat/Context/Fixtures";
    }

    /**
     * @group unit
     */
    public function testCreateUser()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/user.json', [
            'username' => 'paco',
            'email' => 'paco@gmail.com',
            'password' => 'qweqwe1234567890'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(201, $response->getStatusCode());

        $this->client->request('GET', $response->headers->get('location'));

        $response = $this->client->getResponse();

        self::assertResponse($response, "user", 200);
    }

    /**
     * @group unit
     */
    public function testCreateUserWithWrongPassword()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/user.json', [
            'username' => 'paco',
            'email' => 'paco@gmail.com',
            'password' => 'qwe'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('password', $response->getContent());
    }

    /**
     * @group unit
     */
    public function testCreateUserWithWrongEmail()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/user.json', [
            'username' => 'paco',
            'email' => 'paco',
            'password' => 'qwe1313ghg1313'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('email', $response->getContent());
    }

    /**
     * @group unit
     */
    public function testCreateUserWithEmptyParams()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/user.json', [
            'username' => '',
            'email' => '',
            'password' => 'qwe1313ghg1313'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
    }

    /**
     * @group unit
     */
    public function testCreateUserWithWrongUsername()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('POST', '/api/v1/user.json', [
            'username' => 'jorge',
            'email' => 'paco@gmail.com',
            'password' => 'qwe1234567'
        ]);

        $response = $this->client->getResponse();

        self::assertEquals(409, $response->getStatusCode());
        self::assertContains('already_exist', $response->getContent());
    }

    /**
     * @group unit
     */
    public function testFindUserWithWrongUUIDFormat()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('GET', '/api/v1/user/adadadasda.json');

        $response = $this->client->getResponse();

        self::assertEquals(400, $response->getStatusCode());
        self::assertContains('uuid', $response->getContent());
    }
    /**
     * @group unit
     */
    public function testFindUserWithNotExistingUUID()
    {
        $this->loginClient('jorge', 'iyoque123');

        $this->client->request('GET', '/api/v1/user/0cb00000-646e-11e6-a5a2-0000ac1b0000.json');

        $response = $this->client->getResponse();

        self::assertEquals(404, $response->getStatusCode());
    }
}
