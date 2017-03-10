<?php
namespace Leos\Infrastructure\CommonBundle\Pagination;

use Leos\Application\Request\Common\Pagination;

use Pagerfanta\Pagerfanta;
use Hateoas\Configuration\Route;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;

/**
 * Trait PagerTrait
 *
 * @package Leos\Infrastructure\CommonBundle\Pagination
 */
Trait PagerTrait
{
    /**
     * @param Pagerfanta $pager
     * @param string $route
     * @param array $params
     * @param int $limit
     * @param int $page
     *
     * @return PaginatedRepresentation
     */
    public function getPagination(
        Pagerfanta $pager,
        string $route,
        array $params  = [],
        int $limit = Pagination::LIMIT, // I dont like have application inside infrastructure...
        int $page = Pagination::PAGE): PaginatedRepresentation
    {
        $pager
            ->setMaxPerPage($limit)
            ->setCurrentPage($page);

        //Merge pagination parameters
        $params = array_merge($params, [
            'limit' => $limit,
            'page' => $page
        ]);

        return (new PagerfantaFactory())->createRepresentation($pager, new Route($route, $params));
    }

}
