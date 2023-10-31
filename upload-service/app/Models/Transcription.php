<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transcription extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transcriptions';

    protected $fillable = [
        'file_transcription_path',
        'finished_at'
    ];
}
