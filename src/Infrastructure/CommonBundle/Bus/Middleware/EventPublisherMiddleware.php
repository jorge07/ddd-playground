<?php

namespace Leos\Infrastructure\CommonBundle\Bus\Middleware;

use JMS\Serializer\SerializerInterface;
use League\Tactician\Middleware;
use Leos\Domain\Common\Event\EventCollector;
use Leos\Infrastructure\CommonBundle\Event\EventAware;

use OldSound\RabbitMqBundle\RabbitMq\Producer;

class EventPublisherMiddleware implements Middleware
{
    /**
     * @var Producer
     */
    private $producer;

    /**
     * @var EventCollector
     */
    private $eventCollector;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(Producer $producer, EventCollector $eventCollector, SerializerInterface $serializer)
    {
        $this->producer = $producer;
        $this->producer
            ->setContentType('application/json');
        $this->eventCollector = $eventCollector;
        $this->serializer = $serializer;
    }

    public function execute($command, callable $next)
    {
        $returnValue = $next($command);

        $events = $this->eventCollector->events();

        foreach ($events as $event) {

            $symfonyEvent = new EventAware($event);

            $serializedEvent = $this->serializer->serialize($symfonyEvent, 'json');

            $this->producer->publish($serializedEvent, $symfonyEvent->type());
        }

        return $returnValue;    }
}
