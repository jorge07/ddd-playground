<?php

namespace Leos\Application\UseCase\User;

use Leos\Domain\User\Exception\NotFoundException;
use Leos\Domain\User\Model\User;
use Leos\Domain\User\ValueObject\UserId;
use Leos\Domain\User\Repository\UserRepositoryInterface;

/**
 * Class UserQuery
 *
 * @package Leos\Application\UseCase\User
 */
class UserQuery
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * UserQuery constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @param UserId $userId
     * @return User
     * @throws NotFoundException
     */
    public function get(UserId $userId): User
    {
        $user = $this->repository->findById($userId);

        if (!$user) {

            throw new NotFoundException();
        }

        return $user;
    }
}
