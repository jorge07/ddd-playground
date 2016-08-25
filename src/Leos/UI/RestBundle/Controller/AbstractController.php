<?php

namespace Leos\UI\RestBundle\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\ControllerTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AbstractController
 *
 * @package Leos\UI\RestBundle\Controller
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
            $headers
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
        return $this->getRequest()->attributes->get('version') ?: 'v1';
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->requestStack->getMasterRequest();
    }
}
