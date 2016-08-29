<?php

namespace Leos\Infrastructure\UserBundle\Factory;

use Leos\Domain\User\Factory\UserFactoryInterface;
use Leos\Domain\User\Model\User;
use Leos\Infrastructure\Common\Factory\AbstractFactory;
use Leos\Infrastructure\UserBundle\Form\RegisterType;
use Symfony\Component\Form\FormFactory;

/**
 * Class UserFactory
 *
 * @package Leos\Infrastructure\UserBundle\Factory
 */
class UserFactory extends AbstractFactory implements UserFactoryInterface
{
    /**
     * UserFactory constructor.
     * 
     * @param FormFactory $factory
     */
    public function __construct(FormFactory $factory)
    {
        $this->formClass = RegisterType::class;
        parent::__construct($factory);
    }

    /**
     * @param array $data
     *
     * @return User
     */
    public function register(array $data): User
    {
        return $this->execute(self::CREATE, $data);
    }
}
