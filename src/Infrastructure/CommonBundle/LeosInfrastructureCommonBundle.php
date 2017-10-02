<?php

namespace Leos\Infrastructure\CommonBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LeosInfrastructureCommonBundle extends Bundle
{
    public function boot()
    {
        parent::boot();

        // Initialize Event Publisher
        $this->container->get('Leos\Domain\Common\Event\EventDispatcherInterface');
    }
}
