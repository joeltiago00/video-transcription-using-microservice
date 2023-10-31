<?php

namespace Upload\User;

use App\Models\User;
use Repositories\User\UserRepository;

class StoreUser
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly StoreEmailConfirmation $storeEmailConfirmation
    )
    {
    }

    public function handle(string $email): User
    {
        $user = $this->userRepository->store($email);

        $this->storeEmailConfirmation->handle($user);

        return $user;
    }
}
