<?php

namespace Leos\UI\RestBundle\Controller\Monitor;

use Leos\UI\RestBundle\Controller\AbstractController;

use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
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
     * @Operation(
     *     tags={"Monitor"},
     *     summary="Ping status",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     *
     *
     * @return string
     */
    public function getPingAction(): string
    {
        return "pong";
    }
}
