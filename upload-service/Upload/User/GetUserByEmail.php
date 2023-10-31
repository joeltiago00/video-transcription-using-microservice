<?php

namespace Upload\User;

use App\Models\User;
use Repositories\User\UserRepository;

class GetUserByEmail
{
    public function __construct(private readonly UserRepository   $userRepository,)
    {
    }

    public function handle(string $email): ?User
    {
        return $this->userRepository->getByEmail($email);
    }
}
