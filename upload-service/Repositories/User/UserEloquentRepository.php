<?php

namespace Repositories\User;

use App\Models\User;

class UserEloquentRepository implements UserRepository
{
    public function __construct(private readonly User $model)
    {
    }

    public function store(string $email): User
    {
        /** @var User */
        return $this->model
            ->newQuery()
            ->create(['email' => $email]);
    }

    public function getByEmail(string $email): ?User
    {
        /** @var ?User */
        return $this->model
            ->newQuery()
            ->where('email', $email)
            ->first();
    }
}
