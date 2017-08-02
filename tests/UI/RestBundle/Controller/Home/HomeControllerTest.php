<?php

namespace Tests\Leos\UI\RestBundle\Controller\Home;

use Lakion\ApiTestCase\JsonApiTestCase;

class HomeControllerTest extends JsonApiTestCase
{
    public function setUp()
    {
        $this->setUpClient();
    }

    /**
     * @group integration
     */
    public function testGetAction()
    {
        $this->client->request('GET', '/');

        self::assertResponse($this->client->getResponse(), "Home/home");
    }
}
