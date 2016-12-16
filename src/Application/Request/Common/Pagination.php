<?php

namespace Leos\Application\Request\Common;

/**
 * Class Pagination
 * 
 * @package Leos\Application\Request\Common
 */
    class Pagination
{

    const
        LIMIT = 500,
        PAGE = 1
    ;

    /**
     * @var array
     */
    private $filters = [];

    /**
     * @var array
     */
    private $operators = [];

    /**
     * @var array
     */
    private $values = [];

    /**
     * @var array
     */
    private $sort = [];

    /**
     * @var int
     */
    private $limit = self::LIMIT;

    /**
     * @var int
     */
    private $page = self::PAGE;

    /**
     * Pagination constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->filters   = $data['filterParam'] ?? [];
        $this->operators = $data['filterOp'] ?? [];
        $this->values    = $data['filterValue'] ?? [];
        $this->sort      = array_combine($data['orderParameter'] ?? [], $data['orderValue'] ?? []);
        $this->limit     = $data['limit'] ?? self::LIMIT;
        $this->page      = $data['page'] ?? self::PAGE;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return array
     */
    public function getOperators(): array
    {
        return $this->operators;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @return array
     */
    public function getSort(): array
    {
        return $this->sort;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }
}
