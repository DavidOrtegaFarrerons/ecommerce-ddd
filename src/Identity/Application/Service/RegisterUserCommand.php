<?php

namespace App\Identity\Application\Service;

class RegisterUserCommand
{
    private string $email;
    private string $firstName;
    private string $lastName;

    private string $password;

    /**
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     */
    public function __construct(string $email, string $firstName, string $lastName, string $password)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
