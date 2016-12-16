<?php

namespace Leos\Application\UseCase\User\Request;

use Leos\Domain\User\ValueObject\UserId;

/**
 * Class GetUser
 *
 * @package Leos\Application\UseCase\User\Request
 */
class GetUser
{
    /**
     * @var UserId
     */
    private $uuid;

    /**
     * GetUser constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {

        $this->uuid = new UserId($uuid);
    }

    /**
     * @return UserId
     */
    public function uuid(): UserId
    {
        return $this->uuid;
    }
}