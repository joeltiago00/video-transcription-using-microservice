<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $path
 * @property string $mimetype
 * @property float $size
 */
class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'files';

    protected $fillable = [
        'path',
        'mimetype',
        'size'
    ];

    protected $casts = [
        'size' => 'float'
    ];
}
