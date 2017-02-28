<?php

namespace Leos\Application\UseCase\Security;

use Leos\Application\UseCase\Security\Request\Login;

use Leos\Domain\Security\Exception\AuthenticationException;
use Leos\Domain\User\Repository\UserRepositoryInterface;

use Leos\Infrastructure\SecurityBundle\Security\Model\Auth;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;

use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginHandler
 *
 * @package Leos\Application\UseCase\Security
 */
class LoginHandler
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
     * LoginHandler constructor.
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
     * @param Login $request
     * @return string
     * @throws AuthenticationException
     */
    public function handle(Login $request): string
    {
        $user = $this->userRepository->oneByUsername($request->username());

        if (!$user) {

            throw new AuthenticationException();
        }

        $authUser = new Auth($user->id()->__toString(), $user->auth());

        $encoder = $this->encoderFactory->getEncoder($authUser);

        if (!$encoder->isPasswordValid($authUser->getPassword(), $request->plainPassword(), $authUser->getSalt())) {

            throw new AuthenticationException();
        }

        return $this->JWTManager->create($authUser);
    }
}
