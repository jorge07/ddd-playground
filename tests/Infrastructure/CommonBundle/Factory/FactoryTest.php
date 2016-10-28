<?php

namespace Tests\Leos\Infrastructure\CommonBundle\Factory;

use Leos\Infrastructure\CommonBundle\Exception\Form\FormFactoryException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Leos\Infrastructure\CommonBundle\Factory\Fixture\FixtureFactory;

/**
 * Class FactoryTest
 * @package Tests\Leos\Infrastructure\CommonBundle\Factory
 */
class FactoryTest extends WebTestCase
{

    /**
     * @group unit
     */
    public function testConstruct()
    {
        try {
            new FixtureFactory(self::createClient()->getContainer()->get('form.factory'));

            self::assertFalse(true, "exception not throw");
        } catch (FormFactoryException $exception) {

            self::assertTrue(true);
            return;
        }

        self::assertFalse(true, "exception not throw");
    }
}
