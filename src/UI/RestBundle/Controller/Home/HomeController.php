<?php

namespace Leos\UI\RestBundle\Controller\Home;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\RouteResource;

use Leos\UI\RestBundle\Controller\AbstractController;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class HomeController
 *
 * @package Leos\Leos\UI\RestBundle\Controller\Home
 *
 * @RouteResource("", pluralize=false)
 */
class HomeController extends AbstractController
{
    /**
     * @var Router
     */
    private $router;

    /**
     * HomeController constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    /**
     * @ApiDoc(
     *     resource = true,
     *     section="Home",
     *     description = "Home",
     *     statusCodes = {
     *       200 = "Returned when successful"
     *     }
     * )
     *
     * @return array
     */
    public function getAction(): array
    {
        return [
            'wallet' =>  $this->router->generate('post_wallet', ['version' => $this->getVersion()], UrlGeneratorInterface::ABSOLUTE_URL)
        ];
    }

}
