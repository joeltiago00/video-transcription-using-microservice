<?php

namespace Upload\FileUpload;

use App\Enums\CacheEnum;
use App\Enums\MessageEnum;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Repositories\User\UserRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Upload\Cache\AppendCache;
use Upload\File\SaveFile;
use Upload\Messaging\MessagePublishEmailHandler;
use Upload\Transcription\StoreTranscription;
use Upload\User\GetUser;
use Upload\UserFileTranscription\StoreUserFileTranscription;

class FileUpload
{

    public function __construct(
        private readonly GetUser                    $getUser,
        private readonly SaveFile                   $saveFile,
        private readonly StoreTranscription         $storeTranscription,
        private readonly StoreUserFileTranscription $storeUserFileTranscription,
        private readonly AppendCache                $appendCache
    )
    {
    }

    public function handle(array $data): void
    {
        DB::transaction(function () use ($data) {
            $user = $this->getUser->handle($data['email']);
            $userId = $user->getKey();

            $file = $this->saveFile->handle($data['file'], $userId);

            $transcription = $this->storeTranscription->handle();

            $this->storeUserFileTranscription->handle($userId, $file->getKey(), $transcription->getKey());

            $this->appendCache->handle(CacheEnum::EMAIL->key(), [
                'type' => MessageEnum::TRANSCRIPTION_INFO->type(),
                'user_id' => $userId,
                'to' => $user->email,
                'routing_key' => MessageEnum::TRANSCRIPTION_INFO->routingKey(),
                'email_data' => [
                    'file_name' => basename($file->path)
                ]
            ]);

            MessagePublishEmailHandler::handle();
        });
    }
}
