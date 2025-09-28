<?php

namespace App\Identity\Domain\Model;

class User
{
    private UserId $id;
    private Email $email;
    private string $firstName;
    private string $lastName;
    private string $password;

    private array $roles;

    /**
     * @param UserId $id
     * @param Email $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     * @param array $roles
     */
    public function __construct(UserId $id, Email $email, string $firstName, string $lastName, string $password, array $roles = [Role::ROLE_USER])
    {
        $trimmedFirstName = trim($firstName);

        if ($trimmedFirstName === '' || strlen($trimmedFirstName) < 4) {
            throw new InvalidFirstNameException("First name must be at least 4 characters");
        }

        $trimmedLastName = trim($lastName);
        if ($trimmedLastName === '' || strlen($trimmedLastName) < 4) {
            throw new InvalidLastNameException("Last name must be at least 4 characters");
        }

        $this->id = $id;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function id() : UserId
    {
        return $this->id;
    }

    public function email() : Email
    {
        return $this->email;
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function lastName() : string
    {
        return $this->lastName;
    }

    public function password() : string
    {
        return $this->password;
    }

    public function roles() : array
    {
        return $this->roles;
    }
}
