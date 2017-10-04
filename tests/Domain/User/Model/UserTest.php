<?php

namespace Tests\Leos\Domain\User\Model;

use Leos\Domain\Security\Exception\InvalidPasswordException;
use Leos\Domain\Security\Exception\NullPasswordException;
use Leos\Domain\User\Model\User;
use Leos\Domain\User\ValueObject\UserId;
use Leos\Infrastructure\SecurityBundle\ValueObject\EncodedPassword;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package Tests\Leos\Domain\User\Model
 */
class UserTest extends TestCase
{
    /**
     * @group unit
     */
    public function testGetters()
    {
        $user = new User(
            new UserId,
            $username = 'jorge',
            $email = 'jorge.arcoma@gmail.com',
            new EncodedPassword($password = 'iyoquease')
        );
        
        self::assertNotNull($user->uuid());
        self::assertNotNull($user->createdAt());
        self::assertNull($user->updatedAt());
        self::assertEquals($username, $user->auth()->username());
        self::assertEquals($email, $user->email());
        self::assertNotEquals($password, $user->auth()->password());
    }

    /**
     * @group unit
     */
    public function testMinPasswordLength()
    {
        self::expectException(InvalidPasswordException::class);

        new User(
            new UserId,
            'jorge',
            'jorge.arcoma@gmail.com',
            new EncodedPassword('iyoque')
        );
    }

    /**
     * @group unit
     */
    public function testNullPassword()
    {
        self::expectException(NullPasswordException::class);

        new User(
            new UserId,
            'jorge',
            'jorge.arcoma@gmail.com',
            new EncodedPassword(null)
        );
    }

    public static function create(string $name = null, string $email = null, string $pwd = null): User
    {
        return new User(
            new UserId,
            $name ?? 'jorge',
            $email ?? 'jorge.arcoma@gmail.com',
            new EncodedPassword($pwd ?? 'iyoquease')
        );
    }
}
