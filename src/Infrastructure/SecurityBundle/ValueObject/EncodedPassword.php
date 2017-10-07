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
    const
        COST = 12
    ;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var BCryptPasswordEncoder
     */
    private $encoder;
    
    /**
     * EncodedPassword constructor.
     *
     * @param string|null $plainPassword
     *
     * @throws InvalidPasswordException
     * @throws NullPasswordException
     */
    public function __construct(?string $plainPassword = null)
    {
        if (null === $plainPassword) {

            throw new NullPasswordException();
        }

        $this->encoder = new BCryptPasswordEncoder(static::COST);

        $this->validate($plainPassword);

        $this->setPassword($plainPassword);
    }

    private function setPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;

        $this->password = $this->encoder->encodePassword($plainPassword, null);
    }

    public function matchHash(string $encodedPassword): bool
    {
        return password_verify($this->plainPassword, $encodedPassword);
    }

    /**
     * @param string|null $plainPassword
     * @throws InvalidPasswordException
     */
    private function validate(?string $plainPassword): void
    {
        if (8 > strlen($plainPassword)) {

            throw new InvalidPasswordException();
        }
    }

    public function __toString(): string
    {
        return $this->password;
    }
}
