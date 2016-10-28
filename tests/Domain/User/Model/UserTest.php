<?php

namespace Tests\Leos\Domain\User\Model;

use Leos\Domain\User\Model\User;
use Leos\Infrastructure\SecurityBundle\ValueObject\EncodedPassword;

/**
 * Class UserTest
 *
 * @package Tests\Leos\Domain\User\Model
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $user = new User(
            $username = 'jorge',
            $email = 'jorge.arcoma@gmail.com',
            new EncodedPassword($password = 'iyoquease')
        );

        self::assertNotNull($user->id());
        self::assertNotNull($user->createdAt());
        self::assertNull($user->updatedAt());
        self::assertEquals($username, $user->auth()->username());
        self::assertEquals($email, $user->email());
        self::assertNotEquals($password, $user->auth()->password());
    }

    /**
     * @group unit
     *
     * @expectedException Leos\Domain\Security\Exception\InvalidPasswordException
     */
    public function testMinPasswordLength()
    {
        new User(
            'jorge',
            'jorge.arcoma@gmail.com',
            new EncodedPassword($password = 'iyoque')
        );
    }

    /**
     * @group unit
     *
     * @expectedException Leos\Domain\Security\Exception\NullPasswordException
     */
    public function testNullPassword()
    {
        new User(
            'jorge',
            'jorge.arcoma@gmail.com',
            new EncodedPassword($password = null)
        );
    }

    public static function create(string $name = null, string $email = null, string $pwd = null): User
    {
        return new User($name ?? 'jorge',
            $email ?? 'jorge.arcoma@gmail.com',
            new EncodedPassword($pwd ?? 'iyoquease')
        );
    }
}
