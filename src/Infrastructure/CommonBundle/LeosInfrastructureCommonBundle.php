<?php

namespace Leos\Infrastructure\CommonBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LeosInfrastructureCommonBundle extends Bundle
{
    public function boot()
    {
        $eventDispatcher = $this->container->get('event_dispatcher');
    }
}
