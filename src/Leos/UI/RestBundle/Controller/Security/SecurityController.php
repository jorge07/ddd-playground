<?php

namespace Leos\UI\RestBundle\Controller\Security;

use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 *
 * @package Leos\UI\RestBundle\Controller\Security
 *
 * @RouteResource("Auth", pluralize=false)
 */
class SecurityController
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * SecurityController constructor.
     * 
     * @param AuthenticationUtils $authenticationUtils
     */
    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Wallet",
     *     description = "Login a user on the system",
     *     output = "Leos\Domain\Wallet\Model\Wallet",
     *     statusCodes = {
     *       200 = "Returned when successful",
     *       400 = "Returned when not found"
     *     }
     * )
     *
     * @View(statusCode=200)
     *
     * @return array
     */
    public function loginAction()
    {
        return [
            'errors' => $this->authenticationUtils->getLastAuthenticationError(),
            'last_username' => $this->authenticationUtils->getLastUsername()
        ];
    }
}
