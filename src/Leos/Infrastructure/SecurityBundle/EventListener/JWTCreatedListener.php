<?php

namespace Leos\Infrastructure\SecurityBundle\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JWTCreatedListener
 *
 * @package Leos\Infrastructure\SecurityBundle\EventListener
 */
class JWTCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $expiration = new \DateTime('+1 day');

        $user             = $event->getUser();
        $payload          = $event->getData();
        $payload['exp']   = $expiration->getTimestamp();
        $payload['roles'] = $user->getRoles();

        $event->setData($payload);
    }
}
