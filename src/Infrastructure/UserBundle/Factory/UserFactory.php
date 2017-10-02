<?php

namespace Leos\Infrastructure\UserBundle\Factory;

use Leos\Domain\User\Factory\UserFactoryInterface;
use Leos\Domain\User\Model\User;
use Leos\Infrastructure\CommonBundle\Factory\AbstractFactory;
use Leos\Infrastructure\UserBundle\Factory\Form\RegisterType;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class UserFactory
 *
 * @package Leos\Infrastructure\UserBundle\Factory
 */
class UserFactory extends AbstractFactory implements UserFactoryInterface
{
    public function __construct(FormFactoryInterface $factory)
    {
        $this->formClass = RegisterType::class;
        parent::__construct($factory);
    }

    public function register(array $data): User
    {
        return $this->execute(self::CREATE, $data);
    }
}
