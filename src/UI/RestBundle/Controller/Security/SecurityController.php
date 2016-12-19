<?php

namespace Leos\UI\RestBundle\Controller\Security;

use Leos\Domain\Security\Exception\AuthenticationException;
use Leos\Domain\User\ValueObject\UserId;
use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Application\UseCase\User\Request\Register;
use Leos\Application\UseCase\Security\Request\Login;

use Leos\Domain\User\Model\User;

use Leos\Infrastructure\CommonBundle\Exception\Form\FormException;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

use League\Tactician\CommandBus;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * Class SecurityController
 *
 * @package Leos\UI\RestBundle\Controller\Security
 *
 * @RouteResource("Auth", pluralize=false)
 */
class SecurityController extends AbstractController
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * SecurityController constructor.
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
     *     section="Public",
     *     description = "Login a user on the system",
     *     statusCodes = {
     *       200 = "Returned when successful"
     *     }
     * )
     *
     * @RequestParam(name="_username", description="Unique username identifier")
     * @RequestParam(name="_password", description="User plain password")
     *
     * @View(statusCode=200)
     *
     * @param ParamFetcher $fetcher
     *
     * @throws AuthenticationException
     *
     * @return array
     */
    public function postLoginAction(ParamFetcher $fetcher)
    {
        return [
            'token' => $this->commandBus->handle(
                new Login(
                    $fetcher->get('_username'),
                    $fetcher->get('_password')
                )
            )
        ];
    }


    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Public",
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
     * @return User|\Symfony\Component\Form\FormInterface|\FOS\RestBundle\View\View
     */
    public function postRegisterAction(ParamFetcher $fetcher)
    {
        try {

            /** @var User $user */
            $user = $this->commandBus->handle(
                new Register(
                    new UserId(),
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
        }
    }
}
