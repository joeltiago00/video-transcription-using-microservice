<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $email
 * @property string email_verified_at
 */
class User extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'email_verified_at'
    ];


    public function emailConfirmationToken(): HasMany
    {
        return $this->hasMany(UserEmailConfirmationToken::class);
    }
}
