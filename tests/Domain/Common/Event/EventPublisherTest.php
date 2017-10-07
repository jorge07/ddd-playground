<?php

namespace Tests\Leos\Domain\Common\Event;

use Leos\Domain\Common\Event\EventCollector;
use Leos\Domain\Common\Event\EventDispatcherInterface;
use Leos\Domain\Common\Event\EventPublisher;
use Leos\Domain\User\Event\UserWasCreated;
use Leos\Domain\User\ValueObject\UserId;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EventPublisherTest extends KernelTestCase
{
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function setUp()
    {
        $this->dispatcher = self::bootKernel()
            ->getContainer()
            ->get('Leos\Domain\Common\Event\EventDispatcherInterface')
        ;
    }

    public function testRaiseEventShouldBeRecorded()
    {
        EventPublisher::boot($this->dispatcher);

        EventPublisher::raise(new UserWasCreated(new UserId(), 'paco', 'paco@a.com'));

        $events = EventCollector::instance()->events();

        self::assertCount(1, $events);
        self::assertInstanceOf(UserWasCreated::class, $events[0]);
    }
}
