<?php

namespace Leos\Domain\User\Event\Handler;

use Leos\Infrastructure\CommonBundle\Event\EventAware;

class OnUserWasCreated
{

    public function __invoke(EventAware $eventAware): void
    {
        // I.E send welcome email
    }
}
