<?php

namespace App\Tests\Identity\Application;

use App\Identity\Application\Service\RegisterUserCommand;
use App\Identity\Application\Service\RegisterUserHandler;
use App\Identity\Domain\Model\Email;
use App\Identity\Domain\Model\Exception\UserAlreadyExistsException;
use App\Identity\Domain\Model\PasswordHasher;
use App\Identity\Infrastructure\Persistence\InMemory\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class RegisterUserHandlerTest extends TestCase
{
    private InMemoryUserRepository $userRepository;
    private RegisterUserHandler $registerUserHandler;



    protected function setUp(): void
    {
        $this->userRepository = new InMemoryUserRepository();

        $passwordHasher = new class implements PasswordHasher {
            public function hash(string $plainPassword) : string
            {
                return 'hashed-' . $plainPassword;
            }
        };

        $this->registerUserHandler = new RegisterUserHandler($this->userRepository, $passwordHasher);
    }

    public function testRegisterNewUser() : void
    {
        $command = new RegisterUserCommand(
            'david@example.com',
            'David',
            'User',
            'plain-password'
        );

        $this->registerUserHandler->handle($command);

        $user = $this->userRepository->ofEmail(new Email('david@example.com'));
        $this->assertNotNull($user);

        $this->assertSame('david@example.com', $user->email()->value());
        $this->assertSame('David', $user->firstName());
        $this->assertSame('User', $user->lastName());
        $this->assertSame('hashed-plain-password', $user->password());
    }

    public function testThrowsExceptionIfUserAlreadyExists() : void
    {
        $command = new RegisterUserCommand(
            'david@example.com',
            'David',
            'User',
            'plain-password'
        );

        $this->registerUserHandler->handle($command);

        $this->expectException(UserAlreadyExistsException::class);
        $this->registerUserHandler->handle($command);
    }
}
