<?php

namespace App\Tests\Identity\Domain;

use App\Identity\Domain\Model\Email;
use App\Identity\Domain\Model\Exception\InvalidFirstNameException;
use App\Identity\Domain\Model\Exception\InvalidLastNameException;
use App\Identity\Domain\Model\Role;
use App\Identity\Domain\Model\User;
use App\Identity\Domain\Model\UserId;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testCreatesValidUser(): void
    {
        $user = new User(
            UserId::create(),
            new Email('user@example.com'),
            'John',
            'Smith',
            'hashed-password'
        );

        $this->assertInstanceOf(UserId::class, $user->id());
        $this->assertSame('user@example.com', (string) $user->email());
        $this->assertSame('John', $user->firstName());
        $this->assertSame('Smith', $user->lastName());
        $this->assertSame('hashed-password', $user->password());
        $this->assertContains(Role::ROLE_USER, $user->roles());
    }

    public function testThrowsExceptionForInvalidFirstName(): void
    {
        $this->expectException(InvalidFirstNameException::class);

        new User(
            UserId::create(),
            new Email('user@example.com'),
            'Jo',  // too short
            'Smith',
            'hashed-password'
        );
    }

    public function testThrowsExceptionForInvalidLastName(): void
    {
        $this->expectException(InvalidLastNameException::class);

        new User(
            UserId::create(),
            new Email('user@example.com'),
            'John',
            'Li',  // too short
            'hashed-password'
        );
    }

    public function testAllowsCustomRoles(): void
    {
        $user = new User(
            UserId::create(),
            new Email('user@example.com'),
            'John',
            'Smith',
            'hashed-password',
            [Role::ROLE_ADMIN]
        );

        $this->assertSame([Role::ROLE_ADMIN], $user->roles());
    }
}
