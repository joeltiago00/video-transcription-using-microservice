<?php

namespace Upload\FileUpload;

use Illuminate\Support\Facades\Storage;

class SearchFile
{
    public function handle(string $path, string $disk = 's3'): bool
    {
        return Storage::disk($disk)->exists($path);
    }
}
