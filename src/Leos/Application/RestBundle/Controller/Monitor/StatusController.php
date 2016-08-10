<?php

namespace Leos\Application\RestBundle\Controller\Monitor;

use FOS\RestBundle\Controller\Annotations\RouteResource;
use Leos\Application\RestBundle\Controller\AbstractController;

/**
 * Class StatusController
 *
 * @package Leos\Application\RestBundle\Controller\Monitor
 *
 * @RouteResource("Monitor")
 */
class StatusController extends AbstractController
{
    /**
     * Ping Action
     *
     * @return string
     */
    public function getPingAction(): string
    {
        return "pong";
    }
}
