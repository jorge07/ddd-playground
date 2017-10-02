<?php

namespace Leos\Infrastructure\SecurityBundle\EventListener;

use JMS\Serializer\ArrayTransformerInterface;
use Leos\Infrastructure\SecurityBundle\Security\Model\Auth;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JWTCreatedListener
 *
 * @package Leos\Infrastructure\SecurityBundle\EventListener
 */
class JWTCreatedListener
{
    /**
     * @var ArrayTransformerInterface
     */
    private $serializer;

    public function __construct(ArrayTransformerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $expiration = new \DateTime('+1 day');

        /** @var Auth $user */
        $user             = $event->getUser();
        $payload          = $event->getData();
        $payload['exp']   = $expiration->getTimestamp();

        $serializerUser = $this->serializer->toArray($user);

        $event->setData(array_merge($payload, $serializerUser));
    }
}
