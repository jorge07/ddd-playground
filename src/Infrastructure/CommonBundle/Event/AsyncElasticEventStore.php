<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use Elastica\Document;
use Elastica\Type;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class AsyncElasticEventStore implements ConsumerInterface
{
    /**
     * @var Type
     */
    private $type;

    public function __construct(Type $type)
    {
        $this->type = $type;
    }

    public function execute(AMQPMessage $msg)
    {
        try {
            $event = $this->decode($msg->getBody());

            $this->store($event);

        } catch (\Exception $exception) {

            echo $exception->getMessage();

            echo "\n";

            return self::MSG_REJECT_REQUEUE;
        }

        return self::MSG_ACK;
    }

    private function decode(string $msg): array
    {
      return json_decode($msg, true);
    }

    private function store(array $event): void
    {
        $doc = new Document(
            $event['uuid'],
            $event
        );

        $this->type->addDocument($doc);
    }
}
