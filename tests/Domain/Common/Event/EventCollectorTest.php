<?php

namespace Tests\Leos\Domain\Common\Event;

use Leos\Domain\Common\Event\EventCollector;
use Leos\Domain\User\Event\UserWasCreated;
use Leos\Domain\User\ValueObject\UserId;
use PHPUnit\Framework\TestCase;

class EventCollectorTest extends TestCase
{
    public function setUp()
    {
        $this->tearDown();
        EventCollector::instance()->flush();
    }

    public function testEventIsStored()
    {
        $collector = $this->userCreated();

        $events = $collector->events();

        self::assertEquals('UserWasCreated', $events[0]->type());
    }

    public function testEventFlushCleanAll()
    {
        $collector = $this->userCreated();

        $events = $collector->events();

        $collector->flush();

        self::assertNotEquals(count($events), $collector->events());
    }

    private function userCreated(): EventCollector
    {
        $collector = EventCollector::instance();

        $collector->collect(new UserWasCreated(new UserId(), 'paco', 'paso@pas.com'));

        return $collector;
    }

    public function tearDown()
    {
        EventCollector::instance()->shutdown();
    }
}
