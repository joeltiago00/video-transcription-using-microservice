<?php

namespace Repositories\UserEmailConfirmationToken;

interface UserEmailConfirmationTokenRepository
{
    public function store(int $userId): string;
}
