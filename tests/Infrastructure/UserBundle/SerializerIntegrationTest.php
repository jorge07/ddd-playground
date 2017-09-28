<?php

namespace Tests\Leos\Infrastructure\UserBundle;

use JMS\Serializer\Serializer;
use Lakion\ApiTestCase\JsonApiTestCase;
use Tests\Leos\Domain\User\Model\UserTest;

class SerializerIntegrationTest extends JsonApiTestCase
{

    public function testUserSerialization()
    {
        $this->setUpClient();

        /** @var Serializer $serializer */
        $serializer = $this->client->getContainer()->get('serializer');

        $serializedUser = $serializer->toArray(UserTest::create());

        self::assertNotNull($serializedUser['uuid']);
        self::assertArrayNotHasKey('auth', $serializedUser);
    }
}
