<?php

namespace Repositories\User;

use App\Models\User;

interface UserRepository
{
    public function store(string $email): User;

    public function getByEmail(string $email): ?User;
}
