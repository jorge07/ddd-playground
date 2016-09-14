<?php

namespace Leos\UI\RestBundle\Controller\Security;

use Leos\UI\RestBundle\Controller\AbstractController;

use Leos\Application\UseCase\User\UserCommand;
use Leos\Application\UseCase\Security\SecurityCommand;
use Leos\Application\UseCase\User\Request\RegisterDTO;
use Leos\Application\UseCase\Security\Request\LoginDTO;

use Leos\Domain\User\Model\User;
use Leos\Domain\Security\Exception\InvalidPasswordException;
use Leos\Domain\Security\Exception\AuthenticationException;

use Leos\Infrastructure\CommonBundle\Exception\Form\FormException;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

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
     * @var SecurityCommand
     */
    private $securityCommand;

    /**
     * @var UserCommand
     */
    private $userCommand;

    /**
     * SecurityController constructor.
     *
     * @param SecurityCommand $securityCommand
     * @param UserCommand $userCommand
     */
    public function __construct(SecurityCommand $securityCommand, UserCommand $userCommand)
    {
        $this->securityCommand = $securityCommand;
        $this->userCommand = $userCommand;
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
     * @return array
     */
    public function postLoginAction(ParamFetcher $fetcher)
    {
        try {

            return [
                'token' => $this->securityCommand->login(
                    new LoginDTO(
                        $fetcher->get('_username'),
                        $fetcher->get('_password')
                    )
                )
            ];

        }catch (AuthenticationException $e) {

            throw new UnauthorizedHttpException('login', $e->getMessage(), $e);
        }
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
     * @return User|\Symfony\Component\Form\FormInterface
     */
    public function postRegisterAction(ParamFetcher $fetcher)
    {
        try {

            $user = $this->userCommand->register(
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
