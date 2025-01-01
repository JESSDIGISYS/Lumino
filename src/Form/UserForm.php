<?php

namespace Lumino\Form;

use Lumino\Entity\User;

class UserForm
{
    private string $firstname;

    private string $lastname;

    private string $email;

    private string $password;

    private string $phone;

    private array $errors = [];

    public function __construct(private UserMapper $userMapper)
    {
    }


    public function setFields(string $email, string $password, string $firstname, string $lastname, string $phone): void
    {
        $this->email = $email;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->phone = $phone;
    }

    public function save(): User
    {
        $user = User::create($this->email, $this->password, $this->firstname, $this->lastname, $this->phone);

        $this->userMapper->save($user);

        return $user;
    }

    public function hasValidationErrors(): bool
    {
        return count($this->getValidationErrors()) > 0;
    }

    public function getValidationErrors(): array
    {
        if (!empty($this->errors)) {
            return $this->errors;
        }

        // email length
        if (strlen($this->email) < 5 || strlen($this->email) > 100) {
            $this->errors[] = 'Email must be between 5 and 100 characters';
        }

        // validate email
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            if(empty($this->email) && !str_contains($this->email, '@')) {
                $this->errors[] = 'Email parts are not valid';
            } else {
                $email = explode('@', $this->email);
                $user = $email[0];
                $domain = $email[1];
                if (count($email) !== 2 || empty($user) || empty($domain) || !checkdnsrr($domain, "MX")) {
                    $this->errors[] = 'Email is not a valid email address';
                }
            }
        }

        // password validation
        if (!preg_match("^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$^",
            $this->password)) {
            $this->errors[] = "Invalid password must be at least 8 characters long and must contain at least one number, one uppercase, one lowercase letter, and at least one symbol";
        }

        // firstname length
        if (strlen($this->firstname) < 2 || strlen($this->firstname) > 35) {
            $this->errors[] = 'First name must be between 2 and 35 characters';
        }

        if (!preg_match('/^[a-zA-Z\'\- ]+$/', $this->firstname)) {
            $this->errors[] = 'First Name must only contain letters, spaces, hyphens, or apostrophes.';
        }

        // lastname length
        if (strlen($this->lastname) < 2 || strlen($this->lastname) > 35) {
            $this->errors[] = 'Last name must be between 2 and 35 characters';
        }

        if (!preg_match('/^[a-zA-Z\'\- ]+$/', $this->lastname)) {
            $this->errors[] = 'Last Name must only contain letters, spaces, hyphens, or apostrophes.';
        }
        return $this->errors;
    }

}

