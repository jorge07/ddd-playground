<?php

namespace Leos\Infrastructure\SecurityBundle\Security\Model;

use Leos\Domain\Security\ValueObject\AuthUser;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;

/**
 * Class Auth
 *
 * @package Leos\Infrastructure\SecurityBundle\Security\Model
 */
class Auth implements UserInterface, EncoderAwareInterface
{
    /**
     * @var string
     */
    private $uuid;

    /**
     * @var AuthUser
     */
    private $authUser;

    public function __construct(string $uuid, AuthUser $authUser)
    {
        $this->uuid = $uuid;
        $this->authUser = $authUser;
    }

    public function id(): string
    {
        return $this->uuid;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->authUser->roles();
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->authUser->password();
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->authUser->username();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * Gets the name of the encoder used to encode the password.
     *
     * If the method returns null, the standard way to retrieve the encoder
     * will be used instead.
     *
     * @return string
     */
    public function getEncoderName()
    {
        return 'harsh';
    }
}
