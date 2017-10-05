<?php

namespace Leos\Infrastructure\CommonBundle\Event;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class AsyncEventConsumer implements ConsumerInterface
{

    /**
     * @param AMQPMessage $msg The message
     * @return mixed false to reject and requeue, any other value to acknowledge
     */
    public function execute(AMQPMessage $msg)
    {
        echo $msg->getBody();

        var_dump($msg->getBody());
    }
}
