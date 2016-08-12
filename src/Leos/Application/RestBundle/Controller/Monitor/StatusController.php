<?php

namespace Leos\Application\RestBundle\Controller\Monitor;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
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
     * @ApiDoc(
     *   resource = true,
     *   description = "Ping status",
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @return string
     */
    public function getPingAction(): string
    {
        return "pong";
    }
}
