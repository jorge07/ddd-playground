<?php

namespace Leos\Application\UseCase\Security;

use Leos\Application\UseCase\Security\Request\LoginDTO;

use Leos\Domain\Security\Exception\AuthenticationException;
use Leos\Domain\User\Repository\UserRepositoryInterface;

use Leos\Infrastructure\SecurityBundle\Security\Model\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityCommand
 *
 * @package Leos\Application\UseCase\Security
 */
class SecurityCommand
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     * @var JWTManager
     */
    private $JWTManager;

    /**
     * SecurityCommand constructor.
     *
     * @param AuthenticationUtils $authenticationUtils
     * @param UserRepositoryInterface $userRepository
     * @param EncoderFactory $encoderFactory
     * @param JWTManager $JWTManager
     */
    public function __construct(
        AuthenticationUtils $authenticationUtils,
        UserRepositoryInterface $userRepository,
        EncoderFactory $encoderFactory,
        JWTManager $JWTManager
    )
    {
        $this->authenticationUtils = $authenticationUtils;
        $this->userRepository = $userRepository;
        $this->encoderFactory = $encoderFactory;
        $this->JWTManager = $JWTManager;
    }

    /**
     * @param LoginDTO $dto
     * @return string
     * @throws AuthenticationException
     */
    public function login(LoginDTO $dto): string
    {
        $user = $this->userRepository->findByUsername($dto->username());

        if (!$user) {

            throw new AuthenticationException();
        }

        $encoder = $this->encoderFactory->getEncoder($authUser = new Auth($user->auth()));

        if (!$encoder->isPasswordValid($authUser->getPassword(), $dto->plainPassword(), $authUser->getSalt())) {

            throw new AuthenticationException();
        }

        return $this->JWTManager->create($authUser);
    }
}
