<?php

namespace Tests\Leos\UI\RestBundle\Controller\Monitor;

use Lakion\ApiTestCase\JsonApiTestCase;

/**
 * Class StatusControllerTest
 *
 * @package Leos\UI\RestBundle\Controller\Monitor
 */
class StatusControllerTest extends JsonApiTestCase
{
    public function setUp()
    {
        $this->setUpClient();
    }

    /**
     * @group integration
     */
    public function testPingAction()
    {
        $this->client->request('GET', '/monitor/ping.json');

        self::assertResponse($this->client->getResponse(), "Monitor/ping");
    }
}
