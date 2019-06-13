<?php

namespace Leos\UI\RestBundle\Controller\Security;

use Leos\Domain\Security\Exception\AuthenticationException;
use Leos\Domain\User\ValueObject\UserId;
use Leos\UI\RestBundle\Controller\AbstractBusController;

use Leos\Application\UseCase\User\Request\Register;
use Leos\Application\UseCase\Security\Request\Login;

use Leos\Domain\User\Model\User;

use Leos\Infrastructure\CommonBundle\Exception\Form\FormException;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

/**
 * Class SecurityController
 *
 * @package Leos\UI\RestBundle\Controller\Security
 *
 * @RouteResource("Auth", pluralize=false)
 */
class SecurityController extends AbstractBusController
{
    /**
     * @Operation(
     *     tags={"Public"},
     *     summary="Login a user on the system",
     *     @SWG\Parameter(
     *         name="_username",
     *         in="formData",
     *         description="Unique username identifier",
     *         required=false,
     *         type=""
     *     ),
     *     @SWG\Parameter(
     *         name="_password",
     *         in="formData",
     *         description="User plain password",
     *         required=false,
     *         type=""
     *     ),
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     *
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
    public function postLoginAction(ParamFetcher $fetcher): array
    {
        return [
            'token' => $this->handle(
                new Login(
                    $fetcher->get('_username'),
                    $fetcher->get('_password')
                )
            )
        ];
    }


    /**
     * @Operation(
     *     tags={"Public"},
     *     summary="Register a user on the system",
     *     @SWG\Parameter(
     *         name="username",
     *         in="formData",
     *         description="Unique username",
     *         required=false,
     *         type=""
     *     ),
     *     @SWG\Parameter(
     *         name="email",
     *         in="formData",
     *         description="Unique email",
     *         required=false,
     *         type=""
     *     ),
     *     @SWG\Parameter(
     *         name="password",
     *         in="formData",
     *         description="Plain password",
     *         required=false,
     *         type=""
     *     ),
     *     @SWG\Response(
     *         response="201",
     *         description="Returned when successful"
     *     ),
     *     @SWG\Response(
     *         response="400",
     *         description="Returned when bad request"
     *     ),
     *     @SWG\Response(
     *         response="409",
     *         description="Returned when already exist"
     *     )
     * )
     *
     *
     * @RequestParam(name="username", strict=false, default="", description="Unique username")
     * @RequestParam(name="email", strict=false, default="", description="Unique email")
     * @RequestParam(name="password", strict=false, default="", description="Plain password")
     *
     * @View(statusCode=201, serializerGroups={"Identifier", "Basic"})
     *
     * @param ParamFetcher $fetcher
     *
     * @return \Symfony\Component\Form\FormInterface|\FOS\RestBundle\View\View
     */
    public function postRegisterAction(ParamFetcher $fetcher)
    {
        try {

            /** @var User $user */
            $user = $this->handle(
                new Register(
                    new UserId(),
                    $fetcher->get('username'),
                    $fetcher->get('email'),
                    $fetcher->get('password')
                )
            );

            return $this
                ->routeRedirectView(
                    'get_user',
                    [
                        'uuid' => $user->uuid()->__toString()
                    ]
                )
                ->setData($user)
            ;
        } catch (FormException $e) {

            return $e->getForm();

        } catch (UniqueConstraintViolationException $e) {

            throw new ConflictHttpException('user.exception.already_exist');
        }
    }
}
