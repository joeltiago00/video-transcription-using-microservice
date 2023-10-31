<?php

namespace Tests\Providers\FileUpload;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

//use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploadProvider
{
    public static function payloadSuccess(string $email = ''): array
    {
        return [
            'email' => !empty($email) ? $email : fake()->email(),
            'file' => UploadedFile::fake()->create('video.mp4')
        ];
    }

    public static function payloadInvalidEmail(): array
    {
        return [
            'email' => 'email',
            'file' => UploadedFile::fake()->create('video.mp4')
        ];
    }

    public static function errorInvalidEmail(): array
    {
        return [
            'message' => 'The email field must be a valid email address.',
            'errors' => [
                'email' => ['The email field must be a valid email address.']
            ]
        ];
    }

    public static function payloadInvalidFile(): array
    {
        return [
            'email' => fake()->email(),
            'file' => 'file'
        ];
    }

    public static function errorInvalidFile(): array
    {
        return [
            'message' => 'The file field must be a file.',
            'errors' => [
                'file' => ['The file field must be a file.']
            ]
        ];
    }

    public static function payloadInvalidParameters(): array
    {
        return [
            'email' => 'edd',
            'file' => 'file'
        ];
    }

    public static function errorInvalidParameters(): array
    {
        return [
            'message' => 'The email field must be a valid email address. (and 1 more error)',
            'errors' => [
                'email' => ['The email field must be a valid email address.'],
                'file' => ['The file field must be a file.']
            ]
        ];
    }
}
