<?php

namespace Leos\UI\RestBundle\Controller;

use League\Tactician\CommandBus;

abstract class AbstractBusController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $bus;

    /**
     * @var CommandBus
     */
    private $queryBus;

    public function __construct(CommandBus $bus, CommandBus $queryBus)
    {
        $this->bus = $bus;
        $this->queryBus = $queryBus;
    }

    /**
     * @param object $commandRequest
     * @return mixed
     */
    public function handle($commandRequest)
    {
        return $this->bus->handle($commandRequest);
    }

    /**
     * @param object $commandRequest
     * @return mixed
     */
    public function ask($commandRequest)
    {
        return $this->queryBus->handle($commandRequest);
    }
}
