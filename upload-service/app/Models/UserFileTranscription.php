<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserFileTranscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_file_transcriptions';

    protected $fillable = [
        'user_id',
        'transcription_id',
        'file_id'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function transcription(): HasOne
    {
        return $this->hasOne(Transcription::class);
    }

    public function file(): HasOne
    {
        return $this->hasOne(File::class);
    }
}
