<?php

namespace Leos\Application\RestBundle\Controller;

use FOS\RestBundle\Controller\ControllerTrait;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AbstractController
 *
 * @package Leos\Application\RestBundle\Controller
 */
abstract class AbstractController
{
    use ControllerTrait;

    /**
     * @var RequestStack $requestStack
     */
    private $requestStack;

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    
    /**
     * @param string $route
     * @param array $parameters
     * @param int $statusCode
     * @param array $headers
     * @return \FOS\RestBundle\View\View
     */
    protected function routeRedirectView(
        $route,
        array $parameters = [],
        $statusCode = Response::HTTP_CREATED,
        array $headers = [])
    {
        return View::createRouteRedirect(
            $route,
            array_merge([
                'version' => $this->getVersion(),
                '_format' => $this->getFormat()
            ],
                $parameters
            ),
            $statusCode,
            array_merge(
                $this->getRequest()->headers->all(),
                $headers
            )
        );
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->getRequest()->getRequestFormat('json');
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->getRequest()->attributes->get('version');
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->requestStack->getMasterRequest();
    }
}
