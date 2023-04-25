<?php

namespace App\Domain;

Interface UserRepository
{
    public function findByEmail(string $email): User;

    /**
     * @return User[]
     */
    public function getAll(): array;
}
