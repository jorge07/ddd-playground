<?php

namespace Leos\UI\RestBundle\Controller\Monitor;

use Leos\UI\RestBundle\Controller\AbstractController;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class StatusController
 *
 * @package Leos\UI\RestBundle\Controller\Monitor
 *
 * @RouteResource("Monitor")
 */
class StatusController extends AbstractController
{
    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Monitor",
     *     description = "Ping status",
     *     statusCodes = {
     *       200 = "Returned when successful"
     *     }
     * )
     *
     * @return string
     */
    public function getPingAction(): string
    {
        return "pong";
    }
}
