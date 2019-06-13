<?php

namespace Leos\UI\RestBundle\Controller\User;

use Leos\Application\UseCase\User\Request\GetUser;

use Leos\Domain\User\Model\User;

use Leos\UI\RestBundle\Controller\AbstractBusController;
use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class UserController
 *
 * @RouteResource("User", pluralize=false)
 *
 * @package Leos\UI\RestBundle\Controller\User
 */
class UserController extends AbstractBusController
{
    /**
     * @Operation(
     *     tags={"User"},
     *     summary="Gets a user for the given identifier",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="404",
     *         description="Returned when not found"
     *     )
     * )
     *
     *
     * @View(statusCode=200)
     *
     * @param string $uuid
     * @return User
     */
    public function getAction(string $uuid): User
    {
        return $this->ask(new GetUser($uuid));
    }
}
