<?php

namespace Leos\UI\RestBundle\Controller\Security;

use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;

use Leos\Application\DTO\Security\LoginDTO;
use Leos\Application\UseCase\Security\SecurityCommand;

use Leos\Domain\Security\Exception\AuthenticationException;

use Leos\UI\RestBundle\Controller\AbstractController;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * SecurityController constructor.
     *
     * @param SecurityCommand $securityCommand
     */
    public function __construct(SecurityCommand $securityCommand)
    {
        $this->securityCommand = $securityCommand;
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Wallet",
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
}
