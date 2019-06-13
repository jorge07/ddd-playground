<?php

namespace Leos\UI\RestBundle\Controller\Home;

use Nelmio\ApiDocBundle\Annotation\Operation;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
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

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
    
    /**
     * @Operation(
     *     tags={"Home"},
     *     summary="Home",
     *     @SWG\Response(
     *         response="200",
     *         description="Returned when successful"
     *     )
     * )
     *
     *
     * @return array
     */
    public function getAction(): array
    {
        return [
            'wallet' => $this->route('cget_wallet')
        ];
    }

    private function route(string $routeName): string
    {
        return  $this->router->generate(
            $routeName,
            [
                'version' => $this->getVersion()
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    }

}
