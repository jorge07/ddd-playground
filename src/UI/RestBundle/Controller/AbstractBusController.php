<?php

namespace Leos\UI\RestBundle\Controller;

use League\Tactician\CommandBus;

abstract class AbstractBusController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $bus;

    public function __construct(CommandBus $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param object $commandRequest
     * @return mixed
     */
    public function handle($commandRequest)
    {
        return $this->bus->handle($commandRequest);
    }
}
