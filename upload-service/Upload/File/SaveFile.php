<?php

namespace Upload\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Repositories\File\FileRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Upload\File\DTO\FileDTO;
use Upload\FileUpload\GenerateFilePath;

class SaveFile
{
    private const BASE_PATH = 'users/%s/%s';

    public function __construct(
        private readonly FileRepository   $fileRepository,
        private readonly GenerateFilePath $generateFilePath
    )
    {
    }

    public function handle(UploadedFile $file, int $userId): File
    {
        $clientMimeType = $file->getClientMimeType();
        $path = $this->generateFilePath
            ->handle(
                $this->getBasePath($userId, $clientMimeType),
                $file->getClientOriginalName()
            );

        $this->saveFile($path, $file);

        return $this->fileRepository
            ->store(new FileDTO($path, $clientMimeType, $file->getSize()));
    }

    private function getBasePath(int $userId, string $fileType): string
    {
        return sprintf(self::BASE_PATH, $userId, $fileType);
    }

    private function saveFile(string $path, UploadedFile $file): void
    {
        Storage::disk('s3')->put($path, $file->getContent());
    }
}
