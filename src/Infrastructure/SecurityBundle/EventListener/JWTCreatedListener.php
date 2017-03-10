<?php

namespace Leos\Infrastructure\SecurityBundle\EventListener;

use Leos\Infrastructure\SecurityBundle\Security\Model\Auth;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JWTCreatedListener
 *
 * @package Leos\Infrastructure\SecurityBundle\EventListener
 */
class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        $expiration = new \DateTime('+1 day');

        /** @var Auth $user */
        $user             = $event->getUser();
        $payload          = $event->getData();
        $payload['uid']   = $user->id();
        $payload['exp']   = $expiration->getTimestamp();
        $payload['roles'] = $user->getRoles();

        $event->setData($payload);
    }
}
