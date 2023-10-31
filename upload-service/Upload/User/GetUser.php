<?php

namespace Upload\User;

use App\Models\User;

class GetUser
{
    public function __construct(
        private readonly GetUserByEmail         $getUserByEmail,
        private readonly StoreUser              $storeUser,
        private readonly StoreEmailConfirmation $storeEmailConfirmation
    )
    {
    }

    public function handle(string $email): User
    {
        $user = $this->getUserByEmail->handle($email);

        if ($user) {
            $this->verifyIfEmailIsAlreadyVerified($user);

            return $user;
        }

        return $this->storeUser->handle($email);
    }

    private function verifyIfEmailIsAlreadyVerified(User $user): void
    {
        if (is_null($user->email_verified_at)) {
            $this->storeEmailConfirmation->handle($user);
        }
    }
}
