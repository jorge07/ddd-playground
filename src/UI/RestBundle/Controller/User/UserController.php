<?php

namespace Leos\UI\RestBundle\Controller\User;

use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Application\UseCase\User\UserQuery;
use Leos\Application\UseCase\User\UserCommand;

use Leos\Domain\User\Model\User;
use Leos\Domain\User\ValueObject\UserId;

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
     * @var UserCommand
     */
    private $command;
    
    /**
     * @var UserQuery
     */
    private $query;

    /**
     * UserController constructor.
     * 
     * @param UserCommand $command
     * @param UserQuery $query
     */
    public function __construct(UserCommand $command, UserQuery $query)
    {
        $this->command = $command;
        $this->query = $query;
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
        return $this->query->get(new UserId($uuid));
    }
}
