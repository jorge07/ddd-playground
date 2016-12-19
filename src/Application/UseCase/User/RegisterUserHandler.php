<?php

namespace Leos\Application\UseCase\User;

use Leos\Application\UseCase\User\Request\Register;

use Leos\Domain\User\Model\User;
use Leos\Domain\User\Factory\UserFactoryInterface;
use Leos\Domain\User\Repository\UserRepositoryInterface;

/**
 * Class RegisterUserHandler
 * 
 * @package Leos\Application\UseCase\User
 */
class RegisterUserHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;
    
    /**
     * @var UserFactoryInterface
     */
    private $factory;

    /**
     * RegisterUserHandler constructor.
     * 
     * @param UserRepositoryInterface $repository
     * @param UserFactoryInterface $factory
     */
    public function __construct(UserRepositoryInterface $repository, UserFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * @param Register $request
     * @return User
     */
    public function handle(Register $request): User
    {
        $user = $this->factory->register($request->toForm());
        
        $this->repository->save($user);

        return $user;
    }
}
