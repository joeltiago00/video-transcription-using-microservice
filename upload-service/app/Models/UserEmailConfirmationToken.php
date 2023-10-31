<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $userId
 * @property string $token
 * @property string $expires_in
 */
class UserEmailConfirmationToken extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_email_confirmation_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'expires_in'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
