<?php

namespace Upload\User;

use App\Enums\CacheEnum;
use App\Enums\MessageEnum;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Repositories\UserEmailConfirmationToken\UserEmailConfirmationTokenRepository;
use Upload\Cache\AppendCache;

class StoreEmailConfirmation
{
    public function __construct(
        private readonly UserEmailConfirmationTokenRepository $emailConfirmationTokenRepository,
        private readonly AppendCache                          $appendCache
    )
    {
    }

    public function handle(User $user): void
    {
        $userId = $user->getKey();
        $emailConfirmationToken = $this->emailConfirmationTokenRepository->store($userId);

        $this->appendCache->handle(CacheEnum::EMAIL->key(), [
            'channel' => 'email',
            'type' => MessageEnum::STORE_USER_EMAIL_CONFIRMATION->type(),
            'user_id' => $userId,
            'to' => $user->email,
            'routing_key' => MessageEnum::STORE_USER_EMAIL_CONFIRMATION->routingKey(),
            'email_data' => [
                'token' => $emailConfirmationToken
            ]
        ]);
    }
}
