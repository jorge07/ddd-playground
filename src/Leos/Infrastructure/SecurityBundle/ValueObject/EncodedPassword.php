<?php

namespace Leos\Infrastructure\SecurityBundle\ValueObject;

use Leos\Domain\Security\Exception\InvalidPasswordException;
use Leos\Domain\Security\Exception\NullPasswordException;
use Leos\Domain\Security\ValueObject\EncodedPasswordInterface;

use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;

/**
 * Class EncodedPassword
 *
 * @package Leos\Infrastructure\SecurityBundle\ValueObject
 */
final class EncodedPassword implements EncodedPasswordInterface
{
    /**
     * @var string
     */
    private $password;

    /**
     * EncodedPassword constructor.
     *
     * @param string|null $plainPassword
     * @throws InvalidPasswordException
     * @throws NullPasswordException
     */
    public function __construct(string $plainPassword = null)
    {
        if (null === $plainPassword) {

            throw new NullPasswordException();
        }

        $this->validate($plainPassword);

        $this->setPassword($plainPassword);
    }

    /**
     * @param string $plainPassword
     */
    private function setPassword(string $plainPassword)
    {
        $encoder = new BCryptPasswordEncoder(12);
        $this->password = $encoder->encodePassword($plainPassword, null);
    }

    /**
     * @param string|null $plainPassword
     * @throws InvalidPasswordException
     */
    private function validate(string $plainPassword = null)
    {
        if (8 > strlen($plainPassword)) {

            throw new InvalidPasswordException();
        }
    }
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->password;
    }
}
