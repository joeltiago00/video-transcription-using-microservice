<?php

namespace Repositories\UserEmailConfirmationToken;

use App\Models\UserEmailConfirmationToken;
use Illuminate\Support\Str;

class UserEmailConfirmationTokenEloquentRepository implements UserEmailConfirmationTokenRepository
{
    public function __construct(private readonly UserEmailConfirmationToken $model)
    {
    }

    public function store(int $userId): string
    {
        /** @var UserEmailConfirmationToken $model */
        $model = $this->model
            ->newQuery()
            ->create([
                'user_id' => $userId,
                'expires_in' => now()->addDay(),
                'token' => Str::uuid()
            ]);

        return $model->token;
    }
}
