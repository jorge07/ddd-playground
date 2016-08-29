<?php

namespace Leos\UI\RestBundle\Controller\User;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Leos\Application\UseCase\User\UserQuery;
use Leos\Domain\Common\Exception\InvalidUUIDException;
use Leos\Domain\Security\Exception\InvalidPasswordException;
use Leos\Domain\User\Exception\NotFoundException;
use Leos\Domain\User\ValueObject\UserId;
use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Application\DTO\User\RegisterDTO;
use Leos\Application\UseCase\User\UserCommand;

use Leos\Domain\User\Model\User;

use Leos\Infrastructure\Common\Exception\Form\FormException;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        try {

            return $this->query->get(new UserId($uuid));

        } catch (NotFoundException $e) {

            throw new NotFoundHttpException($e->getMessage(), $e, $e->getCode());
            
        } catch (InvalidUUIDException $e) {

            throw new BadRequestHttpException($e->getMessage(), $e, $e->getCode());
        }
    }
    
    /**
     * @ApiDoc(
     *     resource = true,
     *     section="User",
     *     description = "Register a user on the system",
     *     output = "Leos\Domain\User\Model\User",
     *     statusCodes = {
     *       201 = "Returned when successful",
     *       400 = "Returned when bad request",
     *       409 = "Returned when already exist"
     *     }
     * )
     *
     * @RequestParam(name="username", strict=false, default="", description="Unique username")
     * @RequestParam(name="email", strict=false, default="", description="Unique email")
     * @RequestParam(name="password", strict=false, default="", description="Plain password")
     *
     * @View(statusCode=202, serializerGroups={"Identifier", "Basic"})
     *
     * @param ParamFetcher $fetcher
     *
     * @return User|\Symfony\Component\Form\FormInterface
     */
    public function postAction(ParamFetcher $fetcher)
    {
        try {

            $user = $this->command->register(
                new RegisterDTO(
                    $fetcher->get('username'),
                    $fetcher->get('email'),
                    $fetcher->get('password')
                )
            );

            return $this->routeRedirectView('get_user', ['uuid' => $user->id()]);
            
        } catch (FormException $e) {

            return $e->getForm();

        } catch (UniqueConstraintViolationException $e) {

            throw new ConflictHttpException('user.exception.already_exist');

        } catch (InvalidPasswordException $e) {

            throw new BadRequestHttpException($e->getMessage(), $e, $e->getCode());
        }
    }
}
