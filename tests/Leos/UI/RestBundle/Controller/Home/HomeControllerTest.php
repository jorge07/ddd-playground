<?php

namespace Tests\Leos\UI\RestBundle\Controller\Home;

use Lakion\ApiTestCase\JsonApiTestCase;

class HomeControllerTest extends JsonApiTestCase
{
    public function setUp()
    {
        $this->setUpClient();
        $this->expectedResponsesPath = $this->client->getContainer()->getParameter('kernel.root_dir') . "/../tests/Leos/UI/Responses/Home";
    }

    /**
     * @group unit
     */
    public function testPingAction()
    {
        $this->client->request('GET', '/api/v1/');

        self::assertResponse($this->client->getResponse(), "home");
    }
}
