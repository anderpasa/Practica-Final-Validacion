<?php

namespace App\Infrastructure\Persistence;

use App\Domain\User;
use App\Domain\UserRepository;

class FileUserRepository implements UserRepository
{
    public function findByEmail(string $email): User
    {
        return new User(1, "email@email.com");
    }

    public function getAll(): array
    {
        return [new User(1, "email@email.com"), new User(2, "another_email@email.com")];
    }
}
