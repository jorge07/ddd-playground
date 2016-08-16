<?php

namespace Tests\Leos\Infrastructure\Common\Factory;

use Lakion\ApiTestCase\ApiTestCase;
use Tests\Leos\Infrastructure\Common\Factory\Fixture\FixtureFactory;

class FactoryTest extends ApiTestCase
{

    /**
     * @group unit
     *
     * @expectedException Leos\Infrastructure\Common\Exception\Form\FormFactoryException
     */
    public function testConstruct()
    {
        new FixtureFactory($this->client->getContainer()->get('form.factory'));
    }
}
