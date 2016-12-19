<?php

namespace Leos\UI\RestBundle\Controller\User;

use League\Tactician\CommandBus;

use Leos\Application\UseCase\User\Request\GetUser;
use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Domain\User\Model\User;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;

/**
 * Class UserController
 *
 * @RouteResource("User", pluralize=false)

 * @package Leos\UI\RestBundle\Controller\User
 */
class UserController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * UserController constructor.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }


    /**
     * @ApiDoc(
     *     resource = true,
     *     section="User",
     *     description = "Gets a user for the given identifier",
     *     output = "Leos\Domain\User\Model\User",
     *     statusCodes = {
     *       200 = "Returned when successful",
     *       404 = "Returned when not found"
     *     }
     * )
     *
     * @View(statusCode=200, serializerGroups={"Identifier", "Basic", "Auth"})
     *
     * @param string $uuid
     * @return User
     */
    public function getAction(string $uuid): User
    {
        return $this->commandBus->handle(new GetUser($uuid));
    }
}
