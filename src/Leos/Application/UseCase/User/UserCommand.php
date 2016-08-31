<?php

namespace Leos\Application\UseCase\User;

use Leos\Application\DTO\User\RegisterDTO;
use Leos\Domain\User\Factory\UserFactoryInterface;
use Leos\Domain\User\Model\User;
use Leos\Domain\User\Repository\UserRepositoryInterface;

/**
 * Class UserCommand
 * 
 * @package Leos\Application\UseCase\User
 */
class UserCommand
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
     * UserCommand constructor.
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
     * @param RegisterDTO $dto
     * @return User
     */
    public function register(RegisterDTO $dto): User
    {
        $user = $this->factory->register($dto->toForm());
        
        $this->repository->save($user);

        return $user;
    }
}
